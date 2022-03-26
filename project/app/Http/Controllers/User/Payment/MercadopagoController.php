<?php

namespace App\Http\Controllers\User\Payment;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use MercadoPago;
use Illuminate\Support\Str;


class MercadopagoController extends Controller
{

    private $access_token;

    public function __construct()
    {
        //Set Spripe Keys
        $gs = Generalsetting::findOrFail(1);
        $this->access_token = $gs->mercado_token;

    }

    public function store(Request $request) {

    
     if(!$request->has('deposit_number')){
         return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
     }
    
            $deposit = Deposit::where('deposit_number',$request->deposit_number)->first();
            $settings = Generalsetting::findOrFail(1);
            $user = User::findOrFail($deposit->user_id);

                $available_currency = array(
                    'ARS',
                    'BRL',
                    'CLP',
                    'MXN',
                    'PEN',
                    'USD',
                    'UYU',
                    'VEF'
                    );
                    if(!in_array($deposit->currency_code,$available_currency))
                    {
                    return redirect()->back()->with('unsuccess','Invalid Currency For Mercadopago.');
                    }

        

        
         
        

        
         MercadoPago\SDK::setAccessToken($settings->mercado_token);
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = round($deposit->amount * $deposit->currency_value,2);
        $payment->token = $request->token;
        $payment->description = 'Deposit';
        $payment->installments = 1;
       
        $payment->payer = array(
            "email" => $user->email,
        );  
      
        
        $payment->save();
        
 
   
        if ($payment->status == 'approved') {
            $txn_id = $payment->id;
            
                    $deposit = Deposit::where('deposit_number',$request->deposit_number)->first();
                   
                    $deposit['status'] = 1;
                    $deposit['method'] = 'MercadoPago';
                    $deposit['txnid'] = $txn_id;
             
                    $deposit->update();
                
                
               $user = User::findOrFail($deposit->user_id);
                $user->balance = $user->balance + $deposit->amount;
                $user->update();
                
                
                 // store in transaction table
            if ($deposit->status == 1) {
                $transaction = new Transaction;
                $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::random(3);
                $transaction->user_id = $deposit->user_id;
                $transaction->amount = $deposit->amount;
                $transaction->user_id = $deposit->user_id;
                $transaction->currency_sign = $deposit->currency;
                $transaction->currency_code = $deposit->currency_code;
                $transaction->currency_value= $deposit->currency_value;
                $transaction->method = $deposit->method;
                $transaction->txnid = $deposit->txnid;
                $transaction->details = 'Payment Deposit';
                $transaction->type = 'plus';
                $transaction->save();
            }
             return redirect(route('user.success',1));
            
        }else{
             return redirect(route('user.success',0));
        }
        
        
    }


   

}