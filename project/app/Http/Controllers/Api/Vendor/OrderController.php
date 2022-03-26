<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Models\VendorOrder;

use App\{
    Models\Order,
    Http\Controllers\Controller,
    Http\Resources\VendorOrderResource,
    Http\Resources\VendorOrderDetailsResource
};



class OrderController extends Controller
{

    public function index()
    {
        try{
        $user = auth()->user();
        $orders = Order::with(array('vendororders' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }))->get()->reject(function($item) use ($user){
            if($item->vendororders()->where('user_id','=',$user->id)->count() == 0){
                return true;
            }
            return false;
          });
        return response()->json(['status' => true, 'data' => VendorOrderResource::collection($orders), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }

    public function show($slug)
    {
        try{
        $order = Order::where('order_number','=',$slug)->first();
        return response()->json(['status' => true, 'data' => new VendorOrderDetailsResource($order), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }

    public function license(Request $request, $slug)
    {
        try{
        $user = auth()->user();
        $order = Order::where('order_number','=',$slug)->first();

        $mainorder = VendorOrder::where('order_number','=',$slug)->first();

        if($mainorder->user_id != $user->id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This order is not your."]]);
        }

        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->new_license_key;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();    
             
        return response()->json(['status' => false, 'data' => ["message" => "Successfully Changed The License Key."], 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
   
    }


    public function status($slug,$status)
    {
        try{
        $user = auth()->user();
        if(!in_array($status, ['pending','processing','completed','declined'])){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Invalid Status."]]);
        }
        $mainorder = VendorOrder::where('order_number','=',$slug)->first();

        if($mainorder->user_id != $user->id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This order is not your."]]);
        }

        if ($mainorder->status == "completed"){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This Order is Already Completed."]]);
        }else{
            $order = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->update(['status' => $status]);
            return response()->json(['status' => false, 'data' => ["message" => "Order Status Updated Successfully"], 'error' => []]);
        }
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

}
