<?php

namespace App\Http\Controllers\Payment;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\PaymentGateway;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class CheckoutController extends Controller
{

    public function loadpayment(Request $request,$slug1,$slug2)
    {
        if($request->has('order_number')){
            $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
            $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
            $payment = $slug1;
            $pay_id = $slug2;
            $gateway = '';
            if($pay_id != 0) {
                $gateway = PaymentGateway::findOrFail($pay_id);
            }
            return view('payment.load.payment',compact('payment','pay_id','gateway','curr'));
        }
    }
    
    public function depositloadpayment(Request $request,$slug1,$slug2)
    {

        if($request->has('deposit_number')){
            $deposit_number = $request->deposit_number;
            $deposit = Deposit::where('deposit_number',$deposit_number)->firstOrFail();
           
            $curr = Currency::where('name',$deposit->currency_code)->firstOrFail();
            $payment = $slug1;
            $pay_id = $slug2;
            $gateway = '';
            if($pay_id != 0) {
                $gateway = PaymentGateway::findOrFail($pay_id);
            }
            return view('payment.load.payment',compact('payment','pay_id','gateway','curr'));
        }
    }


    public function checkout(Request $request)
    {
       
        if($request->has('order_number')){
             $package_data  = DB::table('packages')->where('user_id','=',0)->get();
             $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();
            $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
            if($order->payment_status == 'Pending'){
                return view('payment.checkout',compact('order','package_data','shipping_data'));
            }

        }

    
    }


}
