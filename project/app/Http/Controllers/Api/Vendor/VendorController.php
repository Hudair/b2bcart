<?php

namespace App\Http\Controllers\Api\Vendor;

use App\{
    Models\User,
    Models\Product,
    Models\VendorOrder,
    Models\Verification,
    Models\Generalsetting
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\VendorResource
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class VendorController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        
        try{
        return response()->json(['status' => true, 'data' => new VendorResource(auth()->user()), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }

    //*** GET Request
    public function dashboard()
    {
        try{
        $user = auth()->user(); 
        $data['user'] = $user;
        $data['pending_orders'] = VendorOrder::where('user_id','=',$user->id)->where('status','=','pending')->count(); 
        $data['processing_orders'] = VendorOrder::where('user_id','=',$user->id)->where('status','=','processing')->count(); 
        $data['completed_orders'] = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->count(); 
        $data['total_products'] = count($user->products);
        $data['subscription_plan'] = $user->subscribes()->orderBy('id','desc')->first() ? $user->subscribes()->orderBy('id','desc')->first()->title : 'No'.' '.'Plan'; 
        $data['subscription_plan_price'] = Product::vendorConvertPrice( $user->subscribes()->orderBy('id','desc')->first() ? $user->subscribes()->orderBy('id','desc')->first()->price : 0);
        $data['total_items_sold'] = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('qty');
        $data['total_earnings'] = Product::vendorConvertPrice( VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('price') );
        return response()->json(['status' => true, 'data' => $data, 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }

    }

    //*** POST Request
    public function profileupdate(Request $request)
    {
        try{
        //--- Validation Section
        $rules = [
               'owner_name'  => 'required',
               'shop_number'  => 'required',
               'reg_number'  => 'required',
               'shop_message'  => 'required',
               'shop_details'  => 'required',
               'f_url'  => 'required',
               'g_url'  => 'required',
               't_url'  => 'required',
               'l_url'  => 'required',
               'f_check'  => 'required',
               'g_check'  => 'required',
               't_check'  => 'required',
               'l_check'  => 'required',
               'shop_image'  => 'required|mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        $input = $request->all();  
        $data = auth()->user();    

        if ($file = $request->file('shop_image')) 
         {      
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/vendorbanner',$name);           
            $input['shop_image'] = $name;
        }

        if($request->shop_name){
            unset($input['shop_name']);
        }

        if($request->balance){
            unset($input['balance']);
        }

        if($request->is_vendor){
            unset($input['is_vendor']);
        }

        if($request->email){
            unset($input['email']);
        }

        if($request->ban){
            unset($input['ban']);
        }

        if($request->mail_sent){
            unset($input['mail_sent']);
        }

        if($request->date){
            unset($input['date']);
        }

        if($request->current_balance){
            unset($input['current_balance']);
        }        

        if ($request->f_check == ""){
            $input['f_check'] = 0;
        }
        if ($request->t_check == ""){
            $input['t_check'] = 0;
        }

        if ($request->g_check == ""){
            $input['g_check'] = 0;
        }

        if ($request->l_check == ""){
            $input['l_check'] = 0;
        }


        $data->update($input);
        return response()->json(['status' => true, 'data' => new VendorResource($data), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }
    
    
    public function social_link_update(Request $request){
        
        try{
        //--- Validation Section
                $input = $request->all();  
                $data = auth()->user();    
                  if ($request->f_check == ""){
                    $input['f_check'] = 0;
                }
                if ($request->t_check == ""){
                    $input['t_check'] = 0;
                }
        
                if ($request->g_check == ""){
                    $input['g_check'] = 0;
                }
        
                if ($request->l_check == ""){
                    $input['l_check'] = 0;
                }
         $data->update($input);
         return response()->json(['status' => true, 'data' => new VendorResource($data), 'error' => []]);
        }
         catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }


    //*** POST Request
    public function verifysubmit(Request $request)
    {
        try{
        //--- Validation Section
        $rules = [
          'attachments.*'  => 'mimes:jpeg,jpg,png,svg|max:10000'
           ];
        $customs = [
            'attachments.*.mimes' => 'Only jpeg, jpg, png and svg images are allowed',
            'attachments.*.max' => 'Sorry! Maximum allowed size for an image is 10MB',
                   ];

        $validator = Validator::make(Input::all(), $rules,$customs);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        $data = new Verification();
        $input = $request->all();

        $input['attachments'] = '';
        $i = 0;
                if ($files = $request->file('attachments')){
                    foreach ($files as  $key => $file){
                        $name = time().str_replace(' ', '', $file->getClientOriginalName());
                        if($i == count($files) - 1){
                            $input['attachments'] .= $name;
                        }
                        else {
                            $input['attachments'] .= $name.',';
                        }
                        $file->move('assets/images/attachments',$name);

                    $i++;
                    }
                }
        $input['status'] = 'Pending';        
        $input['user_id'] = auth()->user()->id;
        if($request->verify_id != '0')
        {
            $verify = Verification::find($request->verify_id);
            if(!$verify){
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Verify ID not found.']]);
            }
            $input['admin_warning'] = 0;
            $verify->update($input);
        }
        else{

            $data->fill($input)->save();
        }

        //--- Redirect Section        
        return response()->json(['status' => true, 'data' => ['message' => 'Your Documents Submitted Successfully.'], 'error' => []]);
        //--- Redirect Section Ends     
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }



}
