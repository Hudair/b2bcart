<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserNotification;

class NotificationController extends Controller
{

    public function order_notf_count()
    {
      try{
        $user = auth()->user();
        $data = UserNotification::where('user_id','=',$user->id)->where('is_read','=',0)->get()->count();
        return response()->json(['status' => true, 'data' => $data, 'error' => []]); 
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }            
    } 

    public function order_notf_clear()
    {
      try{
        $user = auth()->user();
        $data = UserNotification::where('user_id','=',$user->id);
        $data->delete();        
        return response()->json(['status' => true, 'data' => ['message' => 'Notification Deleted Successfully.'], 'error' => []]); 
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }   
    } 

    public function order_notf_show()
    {
      try{
        $user = auth()->user();
        $datas = UserNotification::where('user_id','=',$user->id)->get();
        if($datas->count() > 0){
          foreach($datas as $data){
            $data->is_read = 1;
            $data->update();
          }
        }  
        return response()->json(['status' => true, 'data' => $datas, 'error' => []]);     
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }     
         
    } 
}
