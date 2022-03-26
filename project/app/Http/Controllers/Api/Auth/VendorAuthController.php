<?php

namespace App\Http\Controllers\Api\Auth;

use App\{
    Models\User,
    Models\Generalsetting
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\UserResource
};

use Illuminate\Http\Request;
use Validator;

class VendorAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('setapi');
    }

    public function register(Request $request)
    {
      try{
        $rules = [
            'fullname'     => 'required',
            'email'        => 'required|email|unique:users',
            'phone'        => 'required',
            'address'      => 'required',
            'password'     => 'required',
            'shop_name'    => 'required|unique:users',
            'shop_number'  => 'required|max:10',
            'owner_name'   => 'required',
            'shop_address' => 'required',
            'reg_number'   => 'required',
            'shop_message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $gs = Generalsetting::first();

        $user = new User;
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = bcrypt($request->password);
        $user->shop_name = $request->shop_name;
        $user->shop_number = $request->shop_number;
        $user->owner_name = $request->owner_name;
        $user->shop_address = $request->shop_address;
        $user->reg_number = $request->reg_number;
        $user->shop_message = $request->shop_message;
        $user->is_vendor = 1;

        if($gs->is_verification_email == 0)
        {
          $user->email_verified = 'Yes';
        }

        if($gs->is_verification_email == 1)
        {
          $to = $request->email;
          $subject = 'Verify your email address.';
          $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
          //Sending Email To Customer
          if($gs->is_smtp == 1)
          {
          $data = [
              'to' => $to,
              'subject' => $subject,
              'body' => $msg,
          ];

          $mailer = new GeniusMailer();
          $mailer->sendCustomMail($data);
          }
          else
          {
          $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
          mail($to,$subject,$msg,$headers);
          }
        }

        $user->save();
        auth()->login($user);

        return response()->json(['status' => true, 'data' => new UserResource($user), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
      try{
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Email / password didn't match."]]);
        }

        if(auth()->user()->email_verified == 'No')
        {
          auth()->logout();
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Email is not Verified!']]);
        }

        if(auth()->user()->ban == 1)
        {
          auth()->logout();
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Account Has Been Banned.']]);
        }

        if(auth()->user()->is_vendor == 0)
        {
          auth()->logout();
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'You don\'t have the permission to access this section.']]);
        }

        return response()->json(['status' => true, 'data' => ['token' => $token, 'user' => new UserResource(auth()->user())], 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

}