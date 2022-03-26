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

class VoguepayController extends Controller
{
    public function store(Request $request)
    {
        
        if(!$request->has('order_number')){
            return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
        }
        
        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
        $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
        $item_amount = $order->pay_amount * $order->currency_value;

        $order['method'] = $request->method;
        $order['payment_status'] = "Completed";
        $order['txnid'] = $request->ref_id;
        $order->pay_amount = round($item_amount / $order->currency_value, 2);
        
        $order->update();
       return redirect(route('front.payment.success',1));

        
    }

}