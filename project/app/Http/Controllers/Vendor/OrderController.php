<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Order;
use App\Models\VendorOrder;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $orders = VendorOrder::where('user_id','=',$user->id)->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.index',compact('user','orders'));
    }

    public function show($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        $cart = json_decode($order->cart,true);
        return view('vendor.order.details',compact('user','order','cart'));
    }

    public function license(Request $request, $slug)
    {
        $order = Order::where('order_number','=',$slug)->first();
       $cart = json_decode($order->cart,true);
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();         
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }



    public function invoice($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        $cart = json_decode($order->cart,true);
        return view('vendor.order.invoice',compact('user','order','cart'));
    }

    public function printpage($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        $cart = json_decode($order->cart,true);
        return view('vendor.order.print',compact('user','order','cart'));
    }

    public function status($slug,$status)
    {
        $mainorder = VendorOrder::where('order_number','=',$slug)->first();
        if ($mainorder->status == "completed"){
            return redirect()->back()->with('success','This Order is Already Completed');
        }else{

        $user = Auth::user();
        $order = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->update(['status' => $status]);
        return redirect()->route('vendor-order-index')->with('success','Order Status Updated Successfully');
    }
    }

}
