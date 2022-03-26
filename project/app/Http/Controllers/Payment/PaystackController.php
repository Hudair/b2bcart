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
use Auth;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Package;
use Session;

class PaystackController extends Controller
{

    public function store(Request $request)
    {
        
         if(!$request->has('order_number')){
             return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
         }
         
         
        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $input = $request->all();
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
        $item_amount = $order->pay_amount ;
        $item_amount += $charge;
        $order['txnid'] = $request->ref_id;
        $order->packing_cost = $packeging;
        $order->shipping_cost = $shipping;
        $order->payment_status = 'Completed';
        $order->pay_amount = round($item_amount / $order->currency_value, 2);
        $order->method = "Paystack";
        $order->update();
        return redirect(route('front.payment.success',1));
        
    }

}