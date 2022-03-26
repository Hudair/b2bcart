<?php

namespace App\Http\Controllers\Api\User;


use App\{
    Models\User,
    Models\Deposit,
    Models\Currency,
    Models\Transaction,
    Classes\GeniusMailer,
    Models\Generalsetting,
    Http\Controllers\Controller
};

use Illuminate\{
    Http\Request,
    Support\Facades\Redirect
};

use Validator;
use Config;
use Auth;
use Illuminate\Support\Str;
use Session;

class DepositController extends Controller
{


    public function deposits() {
        try{
      $user = Auth::guard('api')->user();
        foreach($user->deposits as $deposit){
            $amount = round($deposit->amount * $deposit->currency_value,2);
            if($deposit->status != 1){
                $deposit['payment_url'] = route('user.deposit.send',$deposit->deposit_number);
                $deposit['amount'] = "$amount";
                $dipositss[] = $deposit;
            }else{
                $deposit['amount'] = "$amount";
                $dipositss[] = $deposit;
            }
        }
        
    
        return response()->json(['status' => true, 'data' =>$dipositss , 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
      }
  
      public function transactions() {
        try{
        $user = Auth::guard('api')->user();
        
        foreach($user->transactions as $transaction){
                $amount = round($transaction->amount * $transaction->currency_value,2);
                $transaction['amount'] = "$amount";
                $transactionss[] = $transaction;
        }
        
        return response()->json(['status' => true, 'data' => $transactionss, 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
      }
  
      public function transactionDetails(Request $request)
      {
        try{

        //--- Validation Section

        $rules = [
            'id'    => 'required'
        ];
        $customs = [
            'id.required' => 'Transaction ID is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $customs);
            
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }     
       
        //--- Validation Section Ends

        $id = $request->id;
        $data = Transaction::find($id);
        if(!$data){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => 'Invalid ID.']]);
        }
        return response()->json(['status' => true, 'data' => $data, 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
      }

    public function store(Request $request) {

        try{

        //--- Validation Section

        $rules = [
            'amount'    => 'required',
            'currency_code' => 'required',
    
        ];
        $customs = [
            'amount.required'   => 'Payment Amount is required.',
            'currency_code.required'   => 'Currency Field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customs);
            
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }     
       
        //--- Validation Section Ends

        $input = $request->all();  

        if(!Auth::guard('api')->check()){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Unauthenticated.']]);
        }
        
      
            $curr = Currency::where('name','=',$request->currency_code)->first();
        
        
   
        $user = Auth::guard('api')->user();

        $deposit_number = Str::random(4).time();
  
        $deposit = new Deposit;
        $deposit->user_id = $user->id;
        $deposit->currency_value = $curr->value;
        $deposit->amount = $request->amount / $curr->value;
        $deposit->currency_code = $curr->name;
        $deposit->method = $request->method;
        $deposit->txnid = $request->txnid;
        $deposit->status = 0;
        $deposit->deposit_number = $deposit_number;
        $deposit->save();
        
        return response()->json(['status' => true, 'data' =>route('user.deposit.send',$deposit_number), 'error' => []]);
        
         }
        
        
        
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }
    
    
    
    function sendDeposit($number){
        dd($number);
    }
}
