<?php

namespace App\Http\Controllers\Api\User;

use App\{
    Models\Subscription,
    Classes\GeniusMailer,
    Models\Generalsetting,
    Models\UserSubscription,
    Http\Controllers\Controller
};

use Illuminate\{
    Http\Request,
    Support\Facades\Input
};

use Auth;
use Validator;
use Carbon\Carbon;

class PackageController extends Controller
{

    public function packages() {
        
        try{
           
        $user = Auth::guard('api')->user();
        $subs = Subscription::all();
       
        $package = $user->subscribes()->where('status',1)->first();
        if($package){
            if(Carbon::now()->format('Y-m-d') > $user->date){
                $package->end_date = date('d/m/Y',strtotime($user->date));
            }else{
                $package->end_date = date('d/m/Y',strtotime($user->date));
            }
        }
       
        
        
        return response()->json(['status' => true, 'data' => ['subs' => $subs, 'currrent_package' => $package], 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
      }
  

      public function packageDetails(Request $request)
      {

        try{
        //--- Validation Section

        $rules = [
            'id'    => 'required'
        ];
        $customs = [
            'id.required' => 'Package ID is required.'
        ];
        $validator = Validator::make(Input::all(), $rules, $customs);
            
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }     
       
        //--- Validation Section Ends

        $gs = Generalsetting::findOrfail(1);
        if($gs->reg_vendor != 1)
        {
            return response()->json(['status' => false, 'data' => [], 'error' => []]);
        }

        $user = Auth::guard('api')->user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $id = $request->id;
        $data = Subscription::find($id);
        if(!$data){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => 'Invalid ID.']]);
        }
        return response()->json(['status' => true, 'data' => ['sub' => $data, 'package' => $package], 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
        
      }


    public function store(Request $request){

        try{

        //--- Validation Section

        $rules = [
            'method'    => 'required',
            'txnid'     => 'required',
            'subscription_id'     => 'required'
        ];
        $customs = [
            'method.required' => 'Payment Method is required.',
            'txnid.required'    => 'Payment Transaction ID is required.',
            'subscription_id.required'     => 'Subscription ID is required'
        ];
        $validator = Validator::make(Input::all(), $rules, $customs);
            
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }     
       
        //--- Validation Section Ends


        if(!Auth::guard('api')->check()){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Unauthenticated.']]);
        }

        $user = Auth::guard('api')->user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($request->subscription_id);
        $settings = Generalsetting::findOrFail(1);
        $today = Carbon::now()->format('Y-m-d');
        $input = $request->all();  


        if(!empty($package))
        {
            if($package->subscription_id == $request->subscription_id)
            {
                $newday = strtotime($today);
                $lastday = strtotime($user->date);
                $secs = $lastday-$newday;
                $days = $secs / 86400;
                $total = $days+$subs->days;
                $user->date = date('Y-m-d', strtotime($today.' + '.$total.' days'));
            }
            else
            {
                $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
            }
        }
        else
        {
            $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
        }

        if($user->is_vendor == 0){

            //--- Validation Section

            $rules = [
                        'shop_name'    => 'required|unique:users',
                        'owner_name'   => 'required',
                        'shop_number'  => 'required',
                        'shop_address' => 'required'
                     ];
            $customs = [
                          'shop_name.required' => 'Shop name is required.',
                          'shop_name.unique' => 'This shop name has already been taken.',
                          'owner_name.required' => 'Owner name is required.',
                          'shop_number.required' => 'Shop number is required.',
                          'shop_address.required' => 'Shop address is required.'
                       ];
            $validator = Validator::make(Input::all(), $rules, $customs);
            
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }     

            //--- Validation Section Ends
            
        }
        $user->is_vendor = 2;
        $user->mail_sent = 1;     
        $user->update($input);
        
        $sub = new UserSubscription;
        $sub->user_id = $user->id;
        $sub->subscription_id = $subs->id;
        $sub->title = $subs->title;
        $sub->currency = $subs->currency;
        $sub->currency_code = $subs->currency_code;
        $sub->price = $subs->price;
        $sub->days = $subs->days;
        $sub->allowed_products = $subs->allowed_products;
        $sub->details = $subs->details;
        $sub->method = $request->method;
        $sub->txnid = $request->txnid;
        $sub->status = 1;
        $sub->save();
        
        if($settings->is_smtp == 1)
        {
            $data = [
                'to' => $user->email,
                'type' => "vendor_accept",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);        
        }
        else
        {
            $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
            mail($user->email,'Your Vendor Account Activated','Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.',$headers);
        }

        return response()->json(['status' => true, 'data' => ['message' => 'Vendor Account Activated Successfully.'], 'error' => []]);
    }
    catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
    }
    }      
}
