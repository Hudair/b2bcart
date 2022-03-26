<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\User;
use App\Models\Withdraw;
use App\Models\Generalsetting;
use Auth;
use App\Models\Currency;
use App\Http\Controllers\Controller;

use App\{
    Http\Resources\WithdrawResource,
    Http\Resources\WithdrawDetailsResource
};

use Illuminate\{
    Http\Request,
    Validation\Rule,
    Support\Facades\Input,
    Database\QueryException
};

class WithdrawController extends Controller
{


  	public function index()
    {
        try{
        $user = auth()->user();
        $withdraws = Withdraw::where('user_id','=',$user->id)->where('type','=','vendor')->orderBy('id','desc')->get();
        return response()->json(['status' => true, 'data' => WithdrawResource::collection($withdraws), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    public function store(Request $request)
    {
        try{
        $user = auth()->user();
        $from = User::findOrFail($user->id);
        $curr = Currency::where('is_default','=',1)->first(); 
        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if($request->amount > 0){

            $amount = $request->amount;
            $amount = round(($amount / $curr->value),2);
            $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
            $finalamount = $amount + $fee;
            if ($from->current_balance >= $finalamount){

                $from->current_balance = $from->current_balance - $finalamount;
                $from->update();

                $finalamount = number_format((float)$finalamount,2,'.','');
                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = $user->id;
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
                $newwithdraw['type'] = 'vendor';
                $newwithdraw->save();

                return response()->json(['status' => true, 'data' => new WithdrawDetailsResource($newwithdraw), 'error' => []]);

            }else{
                 return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Insufficient Balance.']]);
            }
        }
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Please enter a valid amount.']]);
        
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }

    }
}
