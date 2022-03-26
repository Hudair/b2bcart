<?php

namespace App\Http\Controllers\Api\User;


use App\{
    Models\Order,
    Http\Controllers\Controller,
    Http\Resources\OrderResource,
    Http\Resources\OrderDetailsResource
};

use Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(Request $request) {
      try{
          
      if($request->view){
          $paginate = $request->view;
      }else{
          $paginate = 12;
      }
      
      $orders = Order::where('user_id','=',auth()->user()->id)->orderBy('id','desc')->paginate($paginate);
      
    // foreach($orders as $order){
    //     if($order->payment_status != 'Completed'){
    //         if($order->method != 'Cash On Delivery' && $order->method != 'Mobile Money'){
    //             $order['payment_url'] = route('payment.checkout')."?order_number=".$order->order_number;
    //             $orderpro[] = $order;
    //         }else{
    //             $orderpro[] = $order;
    //         }
    //     }else{
    //         $orderpro[] = $order;
    //     }
    // }


      return response()->json(['status' => true, 'data' => OrderResource::collection($orders), 'error' => []]);  
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function order($id) {
      try{
      $order = Order::findOrfail($id);
      return response()->json(['status' => true, 'data' => new OrderDetailsResource($order), 'error' => []]); 
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      } 
    }

    public function updateTransaction(Request $request) {
      try{
      $rules = [
          'order_id' => 'required',
          'transaction_id' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
      }

      $order = Order::find($request->order_id);
      $order->txnid = $request->transaction_id;
      $order->save();

      return response()->json(['status' => true, 'data' => new OrderDetailsResource($order), 'error' => []]); 
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }
}
