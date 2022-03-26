<?php

namespace App\Http\Controllers\Payment;

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
use Illuminate\Http\Request;
use Auth;
use App\Models\Shipping;
use App\Models\Package;
use Session;

class SslController extends Controller
{




    public function store(Request $request){

              if(!$request->has('order_number')){
                  return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
              }
    
    

            $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
             $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
            if($curr->name != "BDT"){
                 return redirect()->back()->with('unsuccess','Please Select BDT Currency For Sslcommerz .');
            }
       
            $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
            $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
            
            $charge = $shipping + $packeging;
            $settings = Generalsetting::findOrFail(1);
           
            $item_amount = $order->pay_amount * $order->currency_value ;
            $item_amount += $charge;
            $txnid = "SSLCZ_TXN_".uniqid();
               
            $order->pay_amount = round($item_amount / $order->currency_value, 2);
            $order['method'] = $request->method;
            $order['txnid'] = $txnid; 
            $order->packing_cost = $packeging;
            $order->shipping_cost = $shipping;
           
            $order->update();

            $post_data = array();
            $post_data['store_id'] = $settings->ssl_store_id;
            $post_data['store_passwd'] = $settings->ssl_store_password;
            $post_data['total_amount'] = $item_amount ;
            $post_data['currency'] = $curr->name;
            $post_data['tran_id'] = $txnid;
            $post_data['success_url'] = action('Payment\SslController@notify');
            $post_data['fail_url'] =  route('payment.checkout')."?order_number=".$order->order_number;
            $post_data['cancel_url'] =  route('payment.checkout')."?order_number=".$order->order_number;
            # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE
            
    
            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $order['customer_name'];
            $post_data['cus_email'] = $order['customer_email'];
            $post_data['cus_add1'] = $order['customer_address'];
            $post_data['cus_city'] = $order['customer_city'];
            $post_data['cus_state'] = '';
            $post_data['cus_postcode'] = $order['customer_zip'];
            $post_data['cus_country'] = $order['customer_country'];
            $post_data['cus_phone'] = '';
            $post_data['cus_fax'] = '';
            
            
            
            # REQUEST SEND TO SSLCOMMERZ
            if($settings->ssl_sandbox_check == 1){
                $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
            }
            else{
            $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php";
            }



            
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $direct_api_url );
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1 );
            curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
            
            
            $content = curl_exec($handle );
            
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            
            
            if($code == 200 && !( curl_errno($handle))) {
                curl_close( $handle);
                $sslcommerzResponse = $content;
            } else {
                curl_close( $handle);
                return redirect()->back()->with('unsuccess',"FAILED TO CONNECT WITH SSLCOMMERZ API");
                exit;
            }
            
            # PARSE THE JSON RESPONSE
            $sslcz = json_decode($sslcommerzResponse, true );
            

            if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            
                    # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                    # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                # header("Location: ". $sslcz['GatewayPageURL']);
                exit;
            } else {
                return redirect()->back()->with('unsuccess',"JSON Data parsing error!");

            }

     }
    

    
    public function notify(Request $request){
            
           
            $input = $request->all();
             $order = Order::where('txnid',$input['tran_id'])->first();
            $success_url = route('front.payment.success',1);
            $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;
            if($input['status'] == 'VALID'){
                
                $data['payment_status'] = 'Completed';
                $order->update($data);
    
                $tempcart = unserialize(bzdecompress(utf8_decode($order->cart)));
                return redirect($success_url)->with(['tempcart' => $tempcart,'temporder' => $order]);
            }
            else {
                $order = Order::where('txnid',$input['tran_id'])->first();
                $order->delete();
                return redirect($cancel_url);
            }
    }
}