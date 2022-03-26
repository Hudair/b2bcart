<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Auth;
use Datatables;
use DB;
use Session;
use Validator;

use App\{
    Http\Resources\ServiceResource,
    Http\Resources\ServiceDetailsResource
};

use Illuminate\{
    Http\Request,
    Validation\Rule,
    Support\Facades\Input
};

class ServiceController extends Controller
{

    //*** GET Request
    public function index()
    {
        try{
        $user = auth()->user();
        $datas =  $user->services()->orderBy('id','desc')->get();
        return response()->json(['status' => true, 'data' => ServiceResource::collection($datas), 'error' => []]);
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
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Service();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/services',$name);           
            $input['photo'] = $name;
        } 
        $input['user_id'] = $user->id;


            $data->fill($input)->save();


        //--- Logic Section Ends

        //--- Redirect Section        
        return response()->json(['status' => true, 'data' => new ServiceDetailsResource($data), 'error' => []]);      
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
        $rules = [
               'photo'      => 'mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Service::findOrFail($id);

        $user = auth()->user();
        if($data->user_id != $user->id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This service is not your.']]);
        }

        $input = $request->all();
            if ($file = $request->file('photo')) 
            {              
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/services',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/services/'.$data->photo)) {
                        unlink(public_path().'/assets/images/services/'.$data->photo);
                    }
                }            
            $input['photo'] = $name;
            } 

                $data->update($input);

        //--- Logic Section Ends

        //--- Redirect Section     
        return response()->json(['status' => true, 'data' => new ServiceDetailsResource($data), 'error' => []]);      
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
        $data = Service::find($id);
        if(!$data){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This service does not exist.']]);
          }
        if($data->user_id == $user->id){
            $data->delete();
            //--- Redirect Section     
            return response()->json(['status' => true, 'data' => ['message' => 'Service Deleted Successfully.'], 'error' => []]);    
            //--- Redirect Section Ends   
        }else{
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This service is not your.']]);
        }
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }

}
