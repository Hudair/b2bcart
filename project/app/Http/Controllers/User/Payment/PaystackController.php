<?php

namespace App\Http\Controllers\User\Payment;

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
use Auth;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Package;
use Session;
use Illuminate\Support\Str;

class PaystackController extends Controller
{

    public function store(Request $request)
    {
        
         if(!$request->has('deposit_number')){
             return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
         }
         
         
        $deposit_number = $request->deposit_number;
        $order = Deposit::where('deposit_number',$deposit_number)->first();
        $input = $request->all();

        $settings = Generalsetting::findOrFail(1);
        $item_amount = $order->pay_amount ;
        $order['txnid'] = $request->ref_id;
        $order->status = 1;
        $order->amount = round($item_amount / $order->currency_value, 2);
        $order->method = "Paystack";
        $order->update();
        
          $user = User::findOrFail($order->user_id);
            $user->balance = $user->balance + $order->amount;
            $user->update();

    if ($order->status == 1) {
            $transaction = new \App\Models\Transaction;
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

}