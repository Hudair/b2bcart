<?php

namespace App\Http\Controllers\User\Payment;

use Mollie\Laravel\Facades\Mollie;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Deposit;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Str;

class MollyController extends Controller
{
 

public function store(Request $request){

     if(!$request->has('deposit_number')){
         return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
     }

    $deposit_number = $request->deposit_number;
    $order = Deposit::where('deposit_number',$deposit_number)->first();
    $curr = Currency::where('name','=',$order->currency_code)->first();
    
    $available_currency = array(
        'AED',
        'AUD',
        'BGN',
        'BRL',
        'CAD',
        'CHF',
        'CZK',
        'DKK',
        'EUR',
        'GBP',
        'HKD',
        'HRK',
        'HUF',
        'ILS',
        'ISK',
        'JPY',
        'MXN',
        'MYR',
        'NOK',
        'NZD',
        'PHP',
        'PLN',
        'RON',
        'RUB',
        'SEK',
        'SGD',
        'THB',
        'TWD',
        'USD',
        'ZAR'
        );
        if(!in_array($curr->name,$available_currency))
        {
        return redirect()->back()->with('unsuccess','Invalid Currency For Molly Payment.');
        }


        $input = $request->all();
        

        $settings = Generalsetting::findOrFail(1);

        $item_amount = round($order->pay_amount / $curr->value, 2);

        
        
        $order['item_name'] = $settings->title." Deposit";
        $order['item_amount'] = $item_amount;
        
        
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $curr->name,
                'value' => ''.sprintf('%0.2f', $order['amount']).'', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $settings->title." Deposit" ,
            'redirectUrl' => route('api.user.molly.notify'),
            ]);

        Session::put('payment_id',$payment->id);
        Session::put('molly_data',$order->id);
        Session::put('paypal_data',$input);
        $payment = Mollie::api()->payments()->get($payment->id);

        return redirect($payment->getCheckoutUrl(), 303);
 }



public function notify(Request $request){
        
        $paypal_data = Session::get('paypal_data');
        $order = Deposit::findOrFail(Session::get('molly_data'));

        $cancel_url = route('user.deposit.send',$order->deposit_number);
        $payment = Mollie::api()->payments()->get(Session::get('payment_id'));
        
        if($payment->status == 'paid'){
        $order['txnid'] = $payment->id;
        $order['method'] = 'Molly';
        $order['status'] = 1;
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
        
         return redirect(route('user.success',1));
        }
        else {
            return redirect($cancel_url);
        }
}



}
