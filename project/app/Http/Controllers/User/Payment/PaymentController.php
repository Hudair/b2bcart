<?php

namespace App\Http\Controllers\User\Payment;
use App\Models\Generalsetting;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use App\Classes\GeniusMailer;
use App\Models\Deposit;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Pagesetting;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\Package;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $_api_context;


    public function __construct()
    {
      
        $gs = Generalsetting::find(1);
        $paypal_conf = \Config::get('paypal');
        $paypal_conf['client_id'] = $gs->paypal_client_id;
        $paypal_conf['secret'] = $gs->paypal_client_secret;
        $paypal_conf['settings']['mode'] = $gs->paypal_sandbox_check == 1 ? 'sandbox' : 'live';
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function store(Request $request)
    {
    
        if(!$request->has('deposit_number')){
             return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
        }
        
        $input = $request->all();
        

        $deposit_number = $request->deposit_number;
        $order = Deposit::where('deposit_number',$deposit_number)->first();

        $curr = Currency::where('name','=',$order->currency_code)->first();

        
        $support = ['USD','EUR'];
        if(!in_array($curr->name,$support)){
            return redirect()->back()->with('unsuccess','Please Select USD Or EUR Currency For Paypal.');
        }
         
        $settings = Generalsetting::findOrFail(1);
        $item_amount = $order->amount * $order->currency_value;
    
       
            
        $settings = Generalsetting::findOrFail(1);
        $order['item_name'] = $settings->title." Order";
        $order['item_amount'] = $item_amount;
        $notify_url = action('User\Payment\PaymentController@notify');
        $cancel_url = route('user.deposit.send',$order->deposit_number);
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($order['item_name']) /** item name **/
            ->setCurrency($curr->name)
            ->setQuantity(1)
            ->setPrice($order['item_amount']); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency($curr->name)
            ->setTotal($order['item_amount']);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($order['item_name'].' Via Paypal');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($notify_url) /** Specify return URL **/
            ->setCancelUrl($cancel_url);
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            return redirect()->back()->with('unsuccess',$ex->getMessage());
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_data',$input);
        Session::put('order_data',$order);
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('unsuccess','Unknown error occurred');
    }

 


    public function notify(Request $request)
    {
    
        $paypal_data = Session::get('paypal_data');
        $order_data = Session::get('order_data');
        $order = Deposit::where('deposit_number',$paypal_data['deposit_number'])->first();
         $cancel_url = route('user.deposit.send',$order->deposit_number);
        $input = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        if (empty( $input['PayerID']) || empty( $input['token'])) {
            return redirect($cancel_url);
        } 
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($input['PayerID']);
        /**Execute the payment **/

        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $resp = json_decode($payment, true);
                
                $order = Deposit::where('deposit_number',$paypal_data['deposit_number'])->first();
                $order->method = "Paypal";
                $order->txnid = $resp['transactions'][0]['related_resources'][0]['sale']['id'];
                $order->status = 1;
                $order->update();
                
                   $user = User::findOrFail($order->user_id);
            $user->balance = $user->balance + $order->amount;
                $user->update();
                
                           // store in transaction table
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
                
                return redirect(route('user.success',1));
          
        }
        return redirect($cancel_url);
    }

   
}