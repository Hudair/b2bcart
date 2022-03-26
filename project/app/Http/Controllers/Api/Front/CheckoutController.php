<?php

namespace App\Http\Controllers\Api\Front;

use App\{
    Models\User,
    Models\Cart,
    Models\Order,
    Models\Coupon,
    Models\Pickup,
    Models\Product,
    Models\Currency,
    Models\OrderTrack,
    Models\Pagesetting,
    Models\VendorOrder,
    Models\Notification,
    Classes\GeniusMailer,
    Models\Generalsetting,
    Models\PaymentGateway,
    Models\UserNotification,
    Http\Controllers\Controller,
    Http\Resources\OrderDetailsResource
};

use Illuminate\Http\Request;

use DB;use Illuminate\Support\Str;
use Auth;
use Validator;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
    
    
        try{

            $datas = ['id','qty','size','size_qty','size_key','size_price','color','keys','values','prices'];
            $input = $request->all();
            $items = $input['items'];
            
            // $file = 'file.txt';
            // file_put_contents('test-'.time().'.txt', $request);
            
            
            
            
            // //$string = ''; //your string
            // $items = str_replace('\n', '', $items);
            // $items = "[" . trim($items) . "]";
            
            
            try{
               $items = json_decode($items, true); 
            }catch(\Exception $e){}
              
         
     
            $new_cart = new Cart(null);
     
            foreach($items as $key => $item){
               
            if(array_keys($item) == $datas){
                $this->addtocart($new_cart, $input['currency_code'],$item['id'],$item['qty'],$item['size'],$item['color'],$item['size_qty'],$item['size_price'],$item['size_key'],$item['keys'],$item['values'],$item['prices']);
            }
            }
    
            $cart = new Cart($new_cart);
    
     
    
            $gs = Generalsetting::find(1);
    
            $currency_code = $input['currency_code'];

            if (!empty($currency_code)) {
                $curr = Currency::where('name','=',$currency_code)->first();
                if(empty($curr)){
                $curr = Currency::where('is_default','=',1)->first();
                }
            }
            else {
            $curr = Currency::where('is_default','=',1)->first();
            }
            
           
            foreach($cart->items as $key => $prod)
            {
               
                if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
                {
                        foreach($prod['item']['license_qty']as $ttl => $dtl)
                        {
                           
                            if($dtl != 0)
                            {
                                
                                $dtl--;
                                $produc = Product::find($prod['item']['id']);
                                $temp = $produc->license_qty;
                                $temp[$ttl] = $dtl;
                                $final = implode(',', $temp);
                                $produc->license_qty = $final;
                                $produc->update();
                                $temp =  $produc->license;
                                $license = $temp[$ttl];
                                $cart->MobileupdateLicense($key,$license);  
                            }                    
                        }
                }
            }
            
            $order = new Order;
            $success_url = action('Front\PaymentController@payreturn');
            $item_name = $gs->title." Order";
            $item_number = Str::random(4).time();
            $order['user_id'] = $request->user_id;
            $new_cart['totalQty'] = $cart->totalQty;
            $new_cart['totalPrice'] = $cart->totalPrice;
            $new_cart['items'] = $cart->items;
            $new_cart = json_encode($new_cart,true);
            $order['cart'] = $new_cart; 
            $order['totalQty'] = $request->totalQty;
            $order['totalQty'] = $request->totalQty;
            $order['pay_amount'] = $request->total / $curr->value;
            $order['method'] = $request->method;
            $order['shipping'] = $request->shipping;
            $order['pickup_location'] = $request->pickup_location;
            $order['customer_email'] = $request->email;
            $order['customer_name'] = $request->name;
            $order['shipping_cost'] = $request->shipping_cost;
            $order['packing_cost'] = $request->packing_cost;
            
            $order['tax'] = $request->tax;
            $order['customer_phone'] = $request->phone;
            $order['order_number'] = Str::random(4).time();
            $order['customer_address'] = $request->address;
            $order['customer_country'] = $request->customer_country;
            $order['customer_city'] = $request->city;
            $order['customer_zip'] = $request->zip;
            $order['shipping_email'] = $request->shipping_email;
            $order['shipping_name'] = $request->shipping_name;
            $order['shipping_phone'] = $request->shipping_phone;
            $order['shipping_address'] = $request->shipping_address;
            $order['shipping_country'] = $request->shipping_country;
            $order['shipping_city'] = $request->shipping_city;
            $order['shipping_zip'] = $request->shipping_zip;
            $order['order_note'] = $request->order_notes;
            $order['coupon_code'] = $request->coupon_code;
            $order['coupon_discount'] = $request->coupon_discount;
            $order['dp'] = $request->dp;
            $order['payment_status'] = "Pending";
            $order['currency_sign'] = $curr->sign;
            $order['currency_value'] = $curr->value;
            $order['txnid'] = $request->txnid;
            $order['dp'] = $request->dp;
            $order['vendor_shipping_id'] = $request->vendor_shipping_id;
            $order['vendor_packing_id'] = $request->vendor_packing_id;
            
            if ($request->affilate_user) 
            {
                $affilate_user = $request->affilate_user;
                $val = $request->total / $curr->value;
                $val = $val / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::find($affilate_user);
                if(!$user){
                    if($order['dp'] == 1){
                        $user->affilate_income += $sub;
                        $user->update();
                    }
                    $order['affilate_user'] = $user->id;
                    $order['affilate_charge'] = $sub;
                }
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

            if($request->coupon_id != "")
            {
                $coupon = Coupon::find($request->coupon_id);
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
                
                if(isset($prod['size_qty']) && $prod['size_qty']  != '' )
                {
                    $product = Product::find($prod['item']['id']);
                    $x = (int)$prod['size_qty'];
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
               
               
                if (isset($prod['stock']))
                {
                    
                    $product = Product::find($prod['item']['id']);
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
               $count = count($cart->items);
              
               
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

            if ($order->user_id != 0 && $order->wallet_price != 0) {
                $transaction = new \App\Models\Transaction;
                $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::rendom(3);
                $transaction->user_id = $order->user_id;
                $transaction->amount = $order->wallet_price;
                $transaction->currency_sign = $order->currency_sign;
                $transaction->currency_code = \App\Models\Currency::where('sign',$order->currency_sign)->first()->name;
                $transaction->currency_value= $order->currency_value;
                $transaction->details = 'Payment Via Wallet';
                $transaction->type = 'minus';
                $transaction->save();
            }

            //Sending Email To Buyer

            if($gs->is_smtp == 1)
            {
            $data = [
                'to' => $request->email,
                'type' => "new_order",
                'cname' => $request->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'wtitle' => "",
                'onumber' => $order->order_number,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendAutoOrderMail($data,$order->id);            
            }
            else
            {
            $to = $request->email;
            $subject = "Your Order Placed!!";
            $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);            
            }

            //Sending Email To Admin

            if($gs->is_smtp == 1)
            {
                $data = [
                    'to' => Pagesetting::find(1)->contact_email,
                    'subject' => "New Order Recieved!!",
                    'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
                ];

                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($data);            
            }
            else
            {
            $to = Pagesetting::find(1)->contact_email;
            $subject = "New Order Recieved!!";
            $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
            }
            unset($order['cart']);
            return response()->json(['status' => true, 'data' => route('payment.checkout').'?order_number='.$order->order_number, 'error' => []]);

        }

        catch(\Exception $e){
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }

    }


    //*** POST Request
    public function update(Request $request, $id)
    {

        try{

        //--- Logic Section
        $data = Order::find($id);

        $input = $request->all();
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends
    

        //--- Redirect Section          
        return response()->json(['status' => true, 'data' => $data, 'error' => []]);  
        //--- Redirect Section Ends     

    
            }else{
            if ($input['status'] == "completed"){
    
                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::find($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }
    

                if( User::where('id', $data->affilate_user)->exists() ){
                    $auser = User::where('id', $data->affilate_user)->first();
                    $auser->affilate_income += $data->affilate_charge;
                    $auser->update();
                }


                $gs = Generalsetting::find(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }
            if ($input['status'] == "declined"){

                if($data->user_id != 0){
                    if($data->wallet_price != 0){
                        $user = User::find($data->user_id);
                        if( $user ){
                            $user->balance = $user->balance + $data->wallet_price;
                            $user->save();
                        }
                    }
                }


                $cart = unserialize(bzdecompress(utf8_decode($data->cart)));

                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['stock'];
                    if($x != null)
                    {
        
                        $product = Product::find($prod['item']['id']);
                        $product->stock = $product->stock + $prod['qty'];
                        $product->update();               
                    }
                }


                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['size_qty'];
                    if(!empty($x))
                    {
                        $product = Product::find($prod['item']['id']);
                        $x = (int)$x;
                        $temp = $product->size_qty;
                        $temp[$prod['size_key']] = $x;
                        $temp1 = implode(',', $temp);
                        $product->size_qty =  $temp1;
                        $product->update();               
                    }
                }


                $gs = Generalsetting::find(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();  
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }
    
    
            } 


        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section          
        return response()->json(['status' => true, 'data' => $data, 'error' => []]);    
         //--- Redirect Section Ends    
    
        }

        }

        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }



    //*** POST Request
    public function delete($id)
    {

        try{

            //--- Logic Section
            $data = Order::find($id);
            if($data){
                $data->delete();
         
                //--- Redirect Section          
                return response()->json(['status' => true, 'data' => 'Order Deleted Successfully', 'error' => []]);  
                //--- Redirect Section Ends     
            }else{
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Order Not Found']]);
            }

        }

        catch(\Exception $e){
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    //*** GET Request
    public function orderDetails(Request $request)
    {
        try{
            if($request->has('order_number')){
                $order_number = $request->order_number;
                $order = Order::where('order_number',$order_number)->firstOrFail();
                return response()->json(['status' => true, 'data' => new OrderDetailsResource($order), 'error' => []]); 
            }
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    protected function addtocart($cart,$currency_code,$p_id,$p_qty,$p_size,$p_color,$p_size_qty,$p_size_price,$p_size_key,$p_keys,$p_values,$p_prices)
    {
        try{
 
            $id = $p_id;
            $qty = $p_qty;
            $size = str_replace(' ','-',$p_size);
            $color = $p_color;
            $size_qty = $p_size_qty;
            $size_price = (double)$p_size_price;
            $size_key = $p_size_key;
            $keys =  $p_keys;
            $keys = explode(",",$keys);
            $values = $p_values;
            $values = explode(",",$values);
            $prices = $p_prices;

            if(!empty($prices)){
                $prices = explode(",",$prices);
            }
    
            $keys = $keys == "" ? '' :implode(',',$keys);
    
            $values = $values == "" ? '' : implode(',',$values );
            if (!empty($currency_code)) {
                $curr = Currency::where('name','=',$currency_code)->first();
                if(!empty($curr)){
                  $curr = Currency::where('is_default','=',1)->first();
                }
            }
            else {
              $curr = Currency::where('is_default','=',1)->first();
            }
    
            $size_price = ($size_price / $curr->value);
            $prod = Product::where('id','=',$id)->first(['id','user_id','slug','name','photo','size','size_qty','size_price','color','price','stock','type','file','link','license','license_qty','measure','whole_sell_qty','whole_sell_discount','attributes']);
    
    
            if($prod->user_id != 0){
            $gs = Generalsetting::find(1);
            $prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission;
            $prod->price = round($prc,2);
            }
            
            if(!empty($prices)){
                if(!empty($prices[0])){
                    foreach($prices as $data){
                        $prod->price += ($data / $curr->value);
                    }
                }
            }
    
            if(!empty($prod->license_qty))
            {
                $lcheck = 1;
                foreach($prod->license_qty as $ttl => $dtl)
                {
                    if($dtl < 1)
                    {
                        $lcheck = 0;
                    }
                    else
                    {
                        $lcheck = 1;
                        break;
                    }                    
                }
                if($lcheck == 0)
                {
                    return false;    
                }
            }
            if(empty($size))
            {
                if(!empty($prod->size))
                { 
                    $size = trim($prod->size[0]);
                }          
                $size = str_replace(' ','-',$size);
            }
     
            if(empty($color))
            {
                if(!empty($prod->color))
                { 
                    $color = $prod->color[0];      
                }          
            }
            $color = str_replace('#','',$color);
            $cart->addnum($prod, $prod->id, $qty, $size,$color,$size_qty,$size_price,$size_key,$keys,$values);
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['dp'] == 1)
            {
                return false;    
            }
            if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['stock'] < 0)
            {
                return false;    
            }
            if(isset($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty']))
            {
                if($cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'),'',$values)]['size_qty'])
                {
                    return false;    
                }           
            }
            $cart->totalPrice = 0;
            foreach($cart->items as $data)
            $cart->totalPrice += $data['price']; 
            
            return $cart->items; 

        }
        catch(\Exception $e){

        }
     
    }
    
    
    function getCoupon(Request $request){
        
        $code = $request->coupon;
        $coupon = Coupon::where('code','=',$code)->where('status',1)->first();
        if($coupon){
            
        $today = date('Y-m-d');
        $from = date('Y-m-d',strtotime($coupon->start_date));
      
        $to = date('Y-m-d',strtotime($coupon->end_date));
  
        if($from <= $today && $to >= $today)
        {
             return response()->json(['status' => true, 'data' =>$coupon, 'error' => []]);
        }else{
             return response()->json(['status' => false, 'data' =>[], 'error' => 'Invalid Coupon']);
        }
             
        }else{
            return response()->json(['status' => false, 'data' =>[], 'error' => 'Coupon Not Found']);
        }
        
    }



}