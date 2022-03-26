<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting as GS;
use App\Models\Currency;
use App\Models\Transaction;
use Session;
use App\Models\Deposit;

class DepositController extends Controller
{
    public function index() {
      return view('user.deposit.index');
    }

    public function transactions() {
      return view('user.transactions');
    }

    public function transhow($id)
    {
      $data = Transaction::find($id);
      return view('load.transaction-details',compact('data'));
    }

    public function create() {
      if (Session::has('currency'))
      {
        $data['curr'] = Currency::find(Session::get('currency'));
      }
      else
      {
        $data['curr'] = Currency::where('is_default','=',1)->first();
      }
      $data['gs'] = GS::first();
      return view('user.deposit.create', $data);
    }
    
    
      
    function sendDeposit($number){
        $deposit = Deposit::where('deposit_number',$number)->first();
        if($deposit->status == 1){
            return response()->json(['status'=>false,'data'=>[],'error'=>"Deposit Allready Added."]);
        }

        return view('user.deposit.payment',compact('deposit'));
    }

}
