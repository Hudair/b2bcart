<?php

namespace App\Http\Controllers\Front;

use Mollie\Laravel\Facades\Mollie;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Session;

class MollyController extends Controller
{


  public function __construct()
    {
        //Set Spripe Keys
        $gs = Generalsetting::findOrFail(1);

    }

public function store(Request $request){

    if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
            
            if($curr->name != "USD")
            {
                return redirect()->back()->with('unsuccess','Please Select USD Currency For Mollie.');
            }

        $input = $request->all();
        Session::put('paypal_data',$input);

        if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name; 
                    $user->email = $request->personal_email;   
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);                     
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");     
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");  
            }
        }

     if (!Session::has('cart')) {
        return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
     }
        $settings = Generalsetting::findOrFail(1);
        $order['item_name'] = $settings->title." Order";
        $order['item_number'] = Str::random(10);
        $order['item_amount'] = $request->total;
        $data['return_url'] = action('Front\PaymentController@notify');
        $data['cancel_url'] = action('Front\PaymentController@paycancle');
        Session::put('paypal_items',$data);

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $curr->name,
                'value' => ''.sprintf('%0.2f', $order['item_amount']).'', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $order['item_name'] ,
            'redirectUrl' => route('molly.notify'),
            ]);
           
        Session::put('payment_id',$payment->id);
        Session::put('molly_data',$order);

        $payment = Mollie::api()->payments()->get($payment->id);
        
  

        return redirect($payment->getCheckoutUrl(), 303);
 }



public function notify(Request $request){
    if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        $paypal_data = Session::get('paypal_data');
        $molly_data = Session::get('molly_data');
        $success_url = action('Front\PaymentController@payreturn');
        $cancel_url = action('Front\PaymentController@paycancle');
        $payment = Mollie::api()->payments()->get(Session::get('payment_id'));
        
        if($payment->status == 'paid'){

           $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            $whole_discount  = 0;
            foreach($cart->items as $key => $prod)
            {
                if(isset($prod['discount1'])){
                    $whole_discount += $prod['discount1'];
                }
                if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
                {
                        foreach($prod['item']['license_qty']as $ttl => $dtl)
                        {
                            if($dtl != 0)
                            {
                                $dtl--;
                                $produc = Product::findOrFail($prod['item']['id']);
                                $temp = $produc->license_qty;
                                $temp[$ttl] = $dtl;
                                $final = implode(',', $temp);
                                $produc->license_qty = $final;
                                $produc->update();
                                $temp =  $produc->license;
                                $license = $temp[$ttl];
                                 $oldCart = Session::has('cart') ? Session::get('cart') : null;
                                 $cart = new Cart($oldCart);
                                 $cart->updateLicense($prod['item']['id'],$license);  
                                 Session::put('cart',$cart);
                                break;
                            }                    
                        }
                }
            }

                     $settings = Generalsetting::findOrFail(1);
                     $order = new Order;

                    $order['user_id'] = $paypal_data['user_id'];
                    $new_cart['totalQty'] = $cart->totalQty;
                    $new_cart['totalPrice'] = $cart->totalPrice;
                    $new_cart['items'] = $cart->items;
                    $new_cart = json_encode($new_cart,true);
                    $order['cart'] = $new_cart;
                    $order['pay_amount'] = $molly_data['item_amount'];
                    $order['method'] = $paypal_data['method'];
                    
                    $order['customer_email'] = $paypal_data['email'];
                    $order['customer_name'] = $paypal_data['name'];
                    $order['customer_phone'] = $paypal_data['phone'];
                    $order['order_number'] = $molly_data['item_number'];
                    $order['shipping'] = $paypal_data['shipping'];
                    $order['totalQty'] = $paypal_data['totalQty'];
                    $order['pickup_location'] = $paypal_data['pickup_location'];
                    $order['customer_address'] = $paypal_data['address'];
                    $order['customer_country'] = $paypal_data['customer_country'];
                    $order['customer_city'] = $paypal_data['city'];
                    $order['customer_zip'] = $paypal_data['zip'];
                    $order['shipping_email'] = $paypal_data['shipping_email'];
                    $order['shipping_name'] = $paypal_data['shipping_name'];
                    $order['shipping_phone'] = $paypal_data['shipping_phone'];
                    $order['shipping_address'] = $paypal_data['shipping_address'];
                    $order['shipping_country'] = $paypal_data['shipping_country'];
                    $order['shipping_city'] = $paypal_data['shipping_city'];
                    $order['shipping_zip'] = $paypal_data['shipping_zip'];
                    $order['order_note'] = $paypal_data['order_notes'];
                    $order['coupon_code'] = $paypal_data['coupon_code'];
                    $order['coupon_discount'] = $paypal_data['coupon_discount'];
                    $order['payment_status'] = 'Completed';
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
                    $order['whole_discount'] = $whole_discount;
                    $order['shipping_cost'] = $paypal_data['shipping_cost'];
                    $order['packing_cost'] = $paypal_data['packing_cost'];
                    $order['tax'] = $paypal_data['tax'];
                    $order['dp'] = $paypal_data['dp'];
                    $order['txnid'] = $payment->id;

                    $order['vendor_shipping_id'] = $paypal_data['vendor_shipping_id'];
                    $order['vendor_packing_id'] = $paypal_data['vendor_packing_id'];

                    if($order['dp'] == 1)
                    {
                        $order['status'] = 'completed';
                    }

                    if (Session::has('affilate')) 
                    {
                        $val = $request->total / $curr->value;
                        $val = $val / 100;
                        $sub = $val * $settings->affilate_charge;
                        $order['affilate_user'] = Session::get('affilate');
                        $order['affilate_charge'] = $sub;
                    }
                    $order->save();


        if($order->dp == 1){
            $track = new OrderTrack;
            $track->title = 'Completed';
            $track->text = 'Your order has completed successfully.';
            $track->order_id = $order->id;
            $track->save();
        }
        else {
            $track = new OrderTrack;
            $track->title = 'Pending';
            $track->text = 'You have successfully placed your order.';
            $track->order_id = $order->id;
            $track->save();
        }
                    
                    $notification = new Notification;
                    $notification->order_id = $order->id;
                    $notification->save();
                    
                    if($paypal_data['coupon_id'] != "")
                    {
                       $coupon = Coupon::findOrFail($paypal_data['coupon_id']);
                       $coupon->used++;
                       if($coupon->times != null)
                       {
                            $i = (int)$coupon->times;
                            $i--;
                            $coupon->times = (string)$i;
                       }
                       $coupon->update();

                    }
                    foreach($cart->items as $prod)
                    {
                        $x = (string)$prod['stock'];
                        if($x != null)
                        {
                            $product = Product::findOrFail($prod['item']['id']);
                            $product->stock =  $prod['stock'];
                            $product->update();                
                        }
                    }

        foreach($cart->items as $prod)
        {
            $x = (string)$prod['size_qty'];
            if(!empty($x))
            {
                $product = Product::findOrFail($prod['item']['id']);
                $x = (int)$x;
                $x = $x - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
                $product->size_qty =  $temp1;
                $product->update();               
            }
        }


        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }


        $notf = null;

        foreach($cart->items as $prod)
        {
            if($prod['item']['user_id'] != 0)
            {
                $vorder =  new VendorOrder;
                $vorder->order_id = $order->id;
                $vorder->user_id = $prod['item']['user_id'];
                $notf[] = $prod['item']['user_id'];
                $vorder->qty = $prod['qty'];
                $vorder->price = $prod['price'];
                $vorder->order_number = $order->order_number;             
                $vorder->save();
            }

        }

        if(!empty($notf))
        {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();    
            }
        }


        $gs = Generalsetting::find(1);

        //Sending Email To Buyer

        if($gs->is_smtp == 1)
        {
        $data = [
            'to' => $paypal_data['email'],
            'type' => "new_order",
            'cname' => $paypal_data['name'],
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            'onumber' => $molly_data['item_number']
        ];

        $mailer = new GeniusMailer();
        $mailer->sendAutoOrderMail($data,$order->id);            
        }
        else
        {
           $to = $paypal_data['email'];
           $subject = "Your Order Placed!!";
           $msg = "Hello ".$paypal_data['name']."!\nYou have placed a new order.\nYour order number is ".$molly_data['item_number'].".Please wait for your delivery. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);            
        }
        //Sending Email To Admin
        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => Pagesetting::find(1)->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$molly_data['item_number'].".Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);            
        }
        else
        {
           $to = Pagesetting::find(1)->contact_email;
           $subject = "New Order Recieved!!";
           $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$molly_data['item_number'].".Please login to your panel to check. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }


        Session::put('temporder_id',$order->id);
        Session::put('tempcart',$cart);
        Session::forget('cart');
        Session::forget('already');
        Session::forget('coupon');
        Session::forget('coupon_total');
        Session::forget('coupon_total1');
        Session::forget('coupon_percentage');
        Session::forget('cart');
        Session::forget('paypal_data');
        Session::forget('molly_data');
            return redirect($success_url);
        }
        else {
            return redirect($cancel_url);
        }

}



}
