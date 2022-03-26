<?php

namespace App\Http\Controllers\Payment;


use Twocheckout;
use Twocheckout_Charge;
use Twocheckout_Error;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipping;
use App\Models\Package;
use Illuminate\Support\Facades\Session;
class TwoCheckoutController extends Controller
{

public function store(Request $request){

   
    $settings = Generalsetting::findOrFail(1);

        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
        
        $input = $request->all();
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
       
        $item_amount = $order->pay_amount ;
        $item_amount += $charge;
        

    if($settings->twocheckout_sandbox_check == 1) {
        $check = 'Y';
    }
    else {
        $check = 'No';
    }

    'https://www.2checkout.com/checkout/purchase?sid='.$settings->twocheckout_seller_id.'&mode=2CO&li_0_name='.$order->customer_name.'&li_0_price='.$item_amount.'&demo='.$check.'';



}



}
