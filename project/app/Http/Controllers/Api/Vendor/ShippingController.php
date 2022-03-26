<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Shipping;
use Datatables;


use App\{
    Http\Resources\ShippingResource,
    Http\Resources\ShippingDetailsResource
};

use Illuminate\{
    Http\Request,
    Validation\Rule,
    Support\Facades\Input,
    Database\QueryException
};

use Validator;
use Auth;
use Session;
use DB;

class ShippingController extends Controller
{

    //*** GET Request
    public function index()
    {
        try{
        $user = auth()->user();
        $datas = Shipping::where('user_id',$user->id)->get();
        return response()->json(['status' => true, 'data' => ShippingResource::collection($datas), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }

    //*** POST Request
    public function store(Request $request)
    {
        try{
        $user = auth()->user();
        //--- Validation Section
        $rules = ['title' => 'unique:shippings'];
        $customs = ['title.unique' => 'This title has already been taken.'];
        $validator = Validator::make(Input::all(), $rules, $customs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
        $sign = Currency::where('is_default','=',1)->first();
        $data = new Shipping();
        $input = $request->all();
        $input['user_id'] = $user->id;
        if($request->price){
            $input['price'] = ($input['price'] / $sign->value);
        }

            $data->fill($input)->save();

        //--- Logic Section Ends

        //--- Redirect Section        
        return response()->json(['status' => true, 'data' => new ShippingDetailsResource($data), 'error' => []]);   
        //--- Redirect Section Ends   
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          } 
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        try{
        //--- Validation Section
        $rules = ['title' => 'unique:shippings,title,'.$id];
        $customs = ['title.unique' => 'This title has already been taken.'];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }        
        //--- Validation Section Ends

        //--- Logic Section
        $sign = Currency::where('is_default','=',1)->first();
        $data = Shipping::findOrFail($id);

        $user = auth()->user();
        if($data->user_id != $user->id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This Shipping is not your.']]);
        }

        $input = $request->all();
        $input['price'] = ($input['price'] / $sign->value);


            $data->update($input);

        //--- Logic Section Ends

        //--- Redirect Section     
        return response()->json(['status' => true, 'data' => new ShippingDetailsResource($data), 'error' => []]);    
        //--- Redirect Section Ends    
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }        
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        try{
        $user = auth()->user();
        $data = Shipping::find($id);
        if(!$data){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This Shipping does not exist.']]);
          }
        if($data->user_id == $user->id){
            $data->delete();
            //--- Redirect Section     
            return response()->json(['status' => true, 'data' => ['message' => 'Shipping Deleted Successfully.'], 'error' => []]);    
            //--- Redirect Section Ends   
        }else{
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This Shipping is not your.']]);
        }
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
     
    }
}