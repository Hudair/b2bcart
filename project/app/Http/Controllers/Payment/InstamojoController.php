<?php

namespace App\Http\Controllers\Payment;

use App\Classes\GeniusMailer;
use App\Classes\Instamojo;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Shipping;
use App\Models\Package;

class InstamojoController extends Controller
{

 public function store(Request $request){

    if(!$request->has('order_number')){
         return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
    }
    
    
        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
    
    
    
    
        if($curr->name != "INR")
        {
            return redirect()->back()->with('unsuccess','Please Select INR Currency For Instamojo.');
        }
    
        $input = $request->all();
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
        $item_name = $settings->title." Order";
        $user_email = $order->customer_email;
        
        
        $item_amount = $order->pay_amount * $order->currency_value;
        $item_amount += $charge;


     $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;
     $notify_url = action('Payment\InstamojoController@notify');


        if($settings->instamojo_sandbox == 1){
            $api = new Instamojo($settings->instamojo_key, $settings->instamojo_token, 'https://test.instamojo.com/api/1.1/');
        }
        else {
            $api = new Instamojo($settings->instamojo_key, $settings->instamojo_token);
        }

    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => $item_name,
            "amount" => $item_amount,
            "send_email" => true,
            "email" => $user_email,
            "redirect_url" => $notify_url
            ));
        
    $redirect_url = $response['longurl'];
    $order->pay_id = $order['pay_id'] = $response['id'];
    $order['pay_amount'] = round($item_amount / $order->currency_value, 2);
    $order['shipping_cost'] = $packeging;
    $order['packing_cost'] = $packeging;
    $order['method'] = $request->method;
    $order->update();
     return redirect($redirect_url);
    }
    catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
    
}




public function notify(Request $request){

    $data = $request->all();

    $order = Order::where('pay_id','=',$data['payment_request_id'])->first();
    $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;
 

    if (isset($order)) {
        $data['txnid'] = $data['payment_id'];
        $data['payment_status'] = 'Completed';
        $order->update($data);
         return redirect(route('front.payment.success',1));
    }
    return $cancel_url;
}


}
