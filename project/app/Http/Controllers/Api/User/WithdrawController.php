<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\User;
use App\Models\Withdraw;
use Auth;
use Validator;

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
        $withdraws = Withdraw::where('user_id','=',$user->id)->where('type','=','user')->orderBy('id','desc')->get();     
        return response()->json(['status' => true, 'data' => WithdrawResource::collection($withdraws), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }
    
    
  	public function methods_field()
    {
        try{
        
        $data ='[
            {
                "name":"Paypal",
                "data":[{
                   "label": "Withdraw Amount",
    				"type": "number",
    				"key": "amount"
                },
                {
                   "label": "Enter Account Emaill ",
    				"type": "text",
    				"key": "acc_email"
                },
                {
                   "label": "Additional Reference(Optional))",
    				"type": "textarea",
    				"key": "reference"
                }]
                
            },
            {
                "name":"Skrill",
                "data":[{
                   "label": "Withdraw Amount",
    				"type": "number",
    				"key": "amount"
                },
                {
                   "label": "Enter Account Emaill ",
    				"type": "text",
    				"key": "acc_email"
                },
                {
                   "label": "Additional Reference(Optional))",
    				"type": "textarea",
    				"key": "reference"
                }]
                
            },
            {
                "name":"Payoneer",
                "data":[{
                   "label": "Withdraw Amount",
    				"type": "number",
    				"key": "amount"
                },
                {
                   "label": "Enter Account Emaill",
    				"type": "text",
    				"key": "acc_email"
                },
                {
                   "label": "Additional Reference(Optional))",
    				"type": "textarea",
    				"key": "reference"
                }]
                
            },
            {
                "name":"Bank",
                "data":[{
                   "label": "Withdraw Amount",
    				"type": "number",
    				"key": "amount"
                },
                {
                   "label": "Enter IBAN/Account No",
    				"type": "text",
    				"key": "acc_email"
                },
                {
                   "label": "Enter Account Emaill",
    				"type": "text",
    				"key": "iban"
                },
                {
                   "label": "Enter Account Name",
    				"type": "text",
    				"key": "acc_name"
                },
                {
                   "label": "Enter Address",
    				"type": "text",
    				"key": "address"
                },
                {
                   "label": "Enter Swift Code",
    				"type": "text",
    				"key": "swift"
                },
                {
                   "label": "Additional Reference(Optional))",
    				"type": "textarea",
    				"key": "reference"
                }]
                
            }
        ]';
		
		$data = json_decode($data,true);
        
        return response()->json(['status' => true, 'data' => $data, 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
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
            
            if ($from->affilate_income >= $amount){
                $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
                $finalamount = $amount - $fee;
               
                if($finalamount <= 0){
                    return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "You Can'n Withdraw This Amount"]]);
                }
              
                if ($from->affilate_income >= $finalamount){
                $finalamount = number_format((float)$finalamount,2,'.','');

                $from->affilate_income = $from->affilate_income - $amount;
                $from->update();

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
                $newwithdraw['type'] = 'user';
                $newwithdraw->save();

                return response()->json(['status' => true, 'data' => new WithdrawDetailsResource($newwithdraw), 'error' => []]);
            }else{
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Insufficient Balance.']]);

            }
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
