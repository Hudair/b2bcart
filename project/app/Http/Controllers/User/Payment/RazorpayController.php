<?php

namespace App\Http\Controllers\User\Payment;

use App\Models\Cart;
use App\Models\User;
use App\Models\Deposit;
use Razorpay\Api\Api;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Currency;
use App\Models\OrderTrack;
use App\Models\VendorOrder;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\Pagesetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Shipping;
use App\Models\Package;
use Illuminate\Support\Str;

class RazorpayController extends Controller
{

    public function __construct()
    {
        
        $rdata = Generalsetting::findOrFail(1);
        $this->keyId = $rdata->razorpay_key;
        $this->keySecret = $rdata->razorpay_secret;
        $this->displayCurrency = 'INR';

        $this->api = new Api($this->keyId, $this->keySecret);
    }

    public function store(Request $request)
    {
        
        
          if(!$request->has('deposit_number')){
              return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
          }
          
            $deposit_number = $request->deposit_number;
            $order = Deposit::where('deposit_number',$deposit_number)->first();
            $curr = Currency::where('name','=',$order->currency_code)->first();
            if($curr->name != "INR"){
                 return redirect()->back()->with('unsuccess','Please Select INR Currency For Razorpay.');
            }
            $input = $request->all();
         
            $notify_url = action('User\Payment\RazorpayController@razorCallback');
         
            $settings = Generalsetting::findOrFail(1);
            
            $item_amount = $order->amount * $curr->value;
            
       
            $item_name = $settings->title." Deposit";
 
        $orderData = [
            'receipt'         => $order->deposit_number,
            'amount'          => round($item_amount) * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
        $razorpayOrderId = $razorpayOrder['id'];
        
        session(['razorpay_order_id'=> $razorpayOrderId]);
                   
                    $order['method'] =$request->method;
                    $order->update();

                    $displayAmount = $amount = $orderData['amount'];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
                        $exchange = json_decode(file_get_contents($url), true);
                    
                        $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
                    }
                    
                    $checkout = 'automatic';
                    
                    if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                    {
                        $checkout = $_GET['checkout'];
                    }
                    
                    $data = [
                        "key"               => $this->keyId,
                        "amount"            => $amount,
                        "name"              => $item_name,
                        "description"       => $item_name,
                        "prefill"           => [
							"name"              => $request->name,
							"email"             => $request->email,
							"contact"           => $request->phone,
                        ],
                        "notes"             => [
							"address"           => $request->address,
							"merchant_order_id" => $order->order_number,
                        ],
                        "theme"             => [
							"color"             => "{{$settings->colors}}"
                        ],
                        "order_id"          => $razorpayOrderId,
                    ];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $data['display_currency']  = $this->displayCurrency;
                        $data['display_amount']    = $displayAmount;
                    }
                    
                    $json = json_encode($data);
                    $displayCurrency = $this->displayCurrency;
                    
        return view( 'front.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
        
    }

    
	public function razorCallback( Request $request ) {

        
        $success = true;
        $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));
        $order_id = $razorpayOrder['receipt'];
        $order = Deposit::where( 'deposit_number', $order_id )->first();
        $cancel_url = route('user.deposit.send',$order->deposit_number);

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            //$api = new Api($keyId, $keySecret);
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        
        if ($success === true)
        {
            
            $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));
        
            $order_id = $razorpayOrder['receipt'];
            $transaction_id = $_POST['razorpay_payment_id'];
            $order = Deposit::where( 'deposit_number', $order_id )->first();
       
            if (isset($order)) {
                $order['txnid'] = $transaction_id;
                $order['status'] = 1;
              
                $order->update();
                   $user = User::findOrFail($order->user_id);
            $user->balance = $user->balance + $order->amount;
                $user->update();
        if ($order->status == 1) {
            $transaction = new \App\Models\Transaction;
            $transaction->txn_number = Str::random(3).substr(time(), 6,8).Str::random(3);
            $transaction->user_id = $order->user_id;
            $transaction->amount = $order->amount;
            $transaction->user_id = $order->user_id;
            $transaction->currency_sign = $order->currency;
            $transaction->currency_code = $order->currency_code;
            $transaction->currency_value= $order->currency_value;
            $transaction->method = $order->method;
            $transaction->txnid = $order->txnid;
            $transaction->details = 'Payment Deposit';
            $transaction->type = 'plus';
            $transaction->save();
        }

            }
            return redirect(route('user.success',1));

        }
        else
        {
            
            return redirect($cancel_url);
        }
        
    }
    

}
