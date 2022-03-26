<?php

namespace App\Http\Controllers\Payment;

use App\Classes\GeniusMailer;
use App\Classes\GeniusMessenger;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\Package;


class FlutterWaveController extends Controller
{

    public function store(Request $request){

         if(!$request->has('order_number')){
             return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
        }
        
        $input = $request->all();
        
       
        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
     
         
         
        
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
        
        $item_amount = $order->pay_amount * $order->currency_value;
        $item_amount += $charge;
   
                $available_currency = array(
                    'BIF',
                    'CAD',
                    'CDF',
                    'CVE',
                    'EUR',
                    'GBP',
                    'GHS',
                    'GMD',
                    'GNF',
                    'KES',
                    'LRD',
                    'MWK',
                    'NGN',
                    'RWF',
                    'SLL',
                    'STD',
                    'TZS',
                    'UGX',
                    'USD',
                    'XAF',
                    'XOF',
                    'ZMK',
                    'ZMW',
                    'ZWD'
                    );
                    if(!in_array($curr->name,$available_currency))
                    {
                    return redirect()->back()->with('unsuccess','Invalid Currency For Flutter Wave.');
                    }

         
            $order['pay_amount'] = round($item_amount / $curr->value, 2);
            $order['method'] = $request->method;
            $order->packing_cost = $packeging;
            $order->shipping_cost = $shipping;
            $order->update();
                   

        // SET CURL

        $curl = curl_init();

        $currency = $curr->name;
        $txref = $order->order_number; // ensure you generate unique references per transaction.
        $PBFPubKey = $settings->flutter_public_key; // get your public key from the dashboard.
        $redirect_url = action('Payment\FlutterWaveController@notify');
        $payment_plan = ""; // this is only required for recurring payments.
        
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
            'amount' => $item_amount,
            'customer_email' => $request->email,
            'currency' => $currency,
            'txref' => $txref,
            'PBFPubKey' => $PBFPubKey,
            'redirect_url' => $redirect_url,
            'payment_plan' => $payment_plan
          ]),
          CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache"
          ],
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
          // there was an error contacting the rave API
          die('Curl returned error: ' . $err);
        }
        
        $transaction = json_decode($response);
        
        if(!$transaction->data && !$transaction->data->link){
          // there was an error from the API
          print_r('API returned error: ' . $transaction->message);
        }
        
        return redirect($transaction->data->link);

   
    }
   
   


   public function notify(Request $request){
   

    $input = $request->all();
    

    if (isset($input['txref'])) {
        $ref = $input['txref'];

        $settings = Generalsetting::findOrFail(1);

        $query = array(
            "SECKEY" => $settings->flutter_secret,
            "txref" => $ref
        );

        $data_string = json_encode($query);
                
        $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        curl_close($ch);

        $resp = json_decode($response, true);
        
        if ($resp['status'] = "success") {
           
            $paymentStatus = $resp['data']['status'];
            $chargeResponsecode = $resp['data']['chargecode'];
    
            if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($paymentStatus == "successful")) {

            $order = Order::where('order_number',$resp['data']['txref'])->first();
            $data['txnid'] = $resp['data']['txid'];
            $data['payment_status'] = 'Completed';
            
            $order->update($data);

            return redirect(route('front.payment.success',1));

        }

        else {
            $payment = Order::where('order_number',$resp['data']['txref'])->first();
            VendorOrder::where('order','=',$payment->id)->delete();
            $payment->delete();
            Session::forget('cart');
            return redirect(route('front.payment.success',0));
        }

        
    }
        else {
            $payment = Order::where('order_number',$resp['data']['txref'])->first();
            VendorOrder::where('order','=',$payment->id)->delete();
            $payment->delete();
            Session::forget('cart');
            return redirect(route('front.payment.success',0));
        }
    }

   }

}
