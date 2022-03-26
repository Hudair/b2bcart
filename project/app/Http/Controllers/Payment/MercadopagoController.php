<?php

namespace App\Http\Controllers\Payment;

use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Package;
use MercadoPago;
class MercadopagoController extends Controller
{
    public function __construct()
    {
        //Set Spripe Keys
        $gs = Generalsetting::findOrFail(1);
        $this->access_token = $gs->mercado_token;

    }

    public function store(Request $request) {
    
    
     if(!$request->has('order_number')){
         return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
     }
    
     $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
             $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
           
            $input = $request->all();
            $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
            $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
            
            $charge = $shipping + $packeging;
            $settings = Generalsetting::findOrFail(1);
           
            $item_amount = $order->pay_amount * $order->currency_value;
            $item_amount += $charge;
            $item_name = $settings->title." Order";

                $available_currency = array(
                    'ARS',
                    'BRL',
                    'USD',
                    'NGN'
                    );
                    if(!in_array($curr->name,$available_currency))
                    {
                    return redirect()->back()->with('unsuccess','Invalid Currency For Mercadopago.');
                    }


         $settings = Generalsetting::findOrFail(1);
        $order->packing_cost = $packeging;
        $order->shipping_cost = $shipping;
        $order->pay_amount = $item_amount / $curr->value;
        $order['method'] = $request->method;
        $order->update();
         
        $cancel_url = action('Front\PaymentController@paycancle');
        $return_url = route('front.payment.success',1);
            
        MercadoPago\SDK::setAccessToken($settings->mercado_token);
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $item_amount;
        $payment->token = $request->token;
        $payment->description = $item_name;
        $payment->installments = 1;
       
            $payment->payer = array(
                "email" => $request->email
            );    
        
        $payment->save();

     

        if ($payment->status == 'approved') {
            $txn_id = $payment->id;

 
        $order = Order::where('order_number', $order_number)->first();
        $data['payment_status'] = "Completed";
        $data['txnid'] = $txn_id;
        if($order->dp == 1)
        {
            $data['status'] = 'completed';
        }
        $order->update($data);

        return redirect($return_url);

    }else{
        return redirect($cancel_url);
    }

}

    
}