<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Auth;

use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use App\Models\Generalsetting;
use App\Models\UserSubscription;
use App\Models\FavoriteSeller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['status']]);
       
    }

    public function index()
    {
        $user = Auth::user();  
        return view('user.dashboard',compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();  
        return view('user.profile',compact('user'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:users,email,'.Auth::user()->id
        ];


        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();  
        $data = Auth::user();        
            if ($file = $request->file('photo')) 
            {    
                $extensions = ['jpeg','jpg','png','svg'];       
                if(!in_array($file->getClientOriginalExtension(),$extensions)){
                    return response()->json(array('errors' => [__('Image format not supported')]));
                }
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/users/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/users/'.$data->photo)) {
                        unlink(public_path().'/assets/images/users/'.$data->photo);
                    }
                }            
            $input['photo'] = $name;
            } 
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg); 
    }

    public function resetform()
    {
        return view('user.reset');
    }

    public function reset(Request $request)
    {
        $user = Auth::user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));     
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));   
            }
        }
        $user->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }


    public function package()
    {
        $user = Auth::user();
        $subs = Subscription::all();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        return view('user.package.index',compact('user','subs','package'));
    }


    public function vendorrequest($id)
    {
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }   
        $subs = Subscription::findOrFail($id);
        $gs = Generalsetting::findOrfail(1);
        $user = Auth::user();

        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        if($gs->reg_vendor != 1)
        {
            return redirect()->back();
        }
        return view('user.package.details',compact('user','subs','package','curr'));
    }

    public function status($status)
    {
        return view('user.success',compact('status'));
    }

    public function vendorrequestsub(Request $request)
    {
        $this->validate($request, [
            'shop_name'   => 'unique:users',
           ],[ 
               'shop_name.unique' => 'This shop name has already been taken.'
            ]);
        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($request->subs_id);
        $settings = Generalsetting::findOrFail(1);
                    $today = Carbon::now()->format('Y-m-d');
                    $input = $request->all();  
                    $user->is_vendor = 2;
                    $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
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
                    $sub->method = 'Free';
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

                    return redirect()->route('user-dashboard')->with('success','Vendor Account Activated Successfully');

    }


    public function favorite($id1,$id2)
    {
        $fav = new FavoriteSeller();
        $fav->user_id = $id1;
        $fav->vendor_id = $id2;
        $fav->save();
    }

    public function favorites()
    {
        $user = Auth::guard('web')->user();
        $favorites = FavoriteSeller::where('user_id','=',$user->id)->get();
        return view('user.favorite',compact('user','favorites'));
    }


    public function favdelete($id)
    {
        $wish = FavoriteSeller::findOrFail($id);
        $wish->delete();
        return redirect()->route('user-favorites')->with('success','Successfully Removed The Seller.');
    }


}
