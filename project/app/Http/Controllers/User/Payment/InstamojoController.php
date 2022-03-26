<?php

namespace App\Http\Controllers\User\Payment;

use App\Classes\GeniusMailer;
use App\Classes\Instamojo;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Deposit;
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
use App\Models\Transaction;
use Illuminate\Support\Str;

class InstamojoController extends Controller
{

 public function store(Request $request){

    if(!$request->has('deposit_number')){
         return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
    }
    
    
        $deposit_number = $request->deposit_number;
        $order = Deposit::where('deposit_number',$deposit_number)->first();
        $curr = Currency::where('name','=',$order->currency_code)->first();
    
    
    
    
        if($curr->name != "INR")
        {
            return redirect()->back()->with('unsuccess','Please Select INR Currency For Instamojo.');
        }
    
        $input = $request->all();
    

        $settings = Generalsetting::findOrFail(1);
        $item_name = $settings->title." Order";
        $user_email = User::findOrFail($order->user_id)->email;
        
        $item_amount = $order->amount * $order->currency_value;



     $cancel_url = route('user.deposit.send',$order->deposit_number);
     $notify_url = action('User\Payment\InstamojoController@notify');


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
    $order['flutter_id'] = $response['id'];
    $order['amount'] = round($item_amount / $order->currency_value, 2);
    $order['method'] = $request->method;
    $order->update();
        $user = User::findOrFail($order->user_id);
            $user->balance = $user->balance + $order->amount;
        $user->update();
    
    // store in transaction table
        if ($order->status == 1) {
            $transaction = new Transaction;
            $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::random(3);
            $transaction->user_id = $order->user_id;
            $transaction->amount = $order->amount;
            $transaction->user_id = $order->user_id;
            $transaction->currency_sign = $order->currency;
            $transaction->currency_code = $order->currency_code;
            $transaction->currency_value= $order->currency_value;
            $transaction->method = $order->method;
            $transaction->txnid = $order->txnid;
            $transaction->details = 'Payment Deposit';
            $transaction->type = 'plus';
            $transaction->save();
        }
    
    
    
     return redirect($redirect_url);
    }
    catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
    
}




public function notify(Request $request){

    $data = $request->all();

    $order = Deposit::where('flutter_id','=',$data['payment_request_id'])->first();

    $cancel_url = route('user.deposit.send',$order->deposit_number);
 

    if (isset($order)) {
        $order['txnid'] = $data['payment_id'];
        $order['status'] = 1;
        $order->update();
         return redirect(route('user.success',1));
    }
    return $cancel_url;
}


}
