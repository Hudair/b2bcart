<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\User;
use App\Models\Withdraw;

use Validator;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

  	public function index()
    {
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')->user()->id)->where('type','=','user')->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('user.withdraw.index',compact('withdraws','sign'));
    }

    public function affilate_code()
    {
        $user = Auth::guard('web')->user();
        return view('user.withdraw.affilate_code',compact('user'));
    }


    public function create()
    {
        $sign = Currency::where('is_default','=',1)->first();
        return view('user.withdraw.withdraw' ,compact('sign'));
    }


    public function store(Request $request)
    {

        $from = User::findOrFail(Auth::guard('web')->user()->id);
        $curr = Currency::where('is_default','=',1)->first(); 
        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if($request->amount > 0){

            $amount = $request->amount;
            $amount = $amount / $curr->value;
            if ($from->affilate_income >= $amount){
                $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
                $finalamount = $amount + $fee;
                if ($from->affilate_income >= $finalamount){

                $from->affilate_income = $from->affilate_income - $finalamount;
                $from->update();

                
                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = Auth::guard('web')->user()->id;
                $newwithdraw['method'] = $request->methods;
                $newwithdraw['acc_email'] = $request->acc_email;
                $newwithdraw['iban'] = $request->iban;
                $newwithdraw['country'] = $request->acc_country;
                $newwithdraw['acc_name'] = $request->acc_name;
                $newwithdraw['address'] = $request->address;
                $newwithdraw['swift'] = $request->swift;
                $newwithdraw['reference'] = $request->reference;
                $newwithdraw['amount'] = $finalamount;
                $newwithdraw['fee'] = $fee;
                $newwithdraw['type'] = 'user';
                $newwithdraw->save();

                return response()->json('Withdraw Request Sent Successfully.'); 
            }else{
                return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 
            }
            }else{
                return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 
            }
        }
        return response()->json(array('errors' => [ 0 => 'Please enter a valid amount.' ])); 

    }
}
