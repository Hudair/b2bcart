<?php

namespace App\Http\Controllers\Payment;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
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
        
        
          if(!$request->has('order_number')){
              return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
          }
          
            $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
            $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
            if($curr->name != "INR"){
                 return redirect()->back()->with('unsuccess','Please Select INR Currency For Razorpay.');
            }
            $input = $request->all();
            $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
            $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
            $notify_url = action('Payment\RazorpayController@razorCallback');
            $charge = $shipping + $packeging;
           
            $settings = Generalsetting::findOrFail(1);
            
            $item_amount = $order->pay_amount * $order->currency_value;
            
            $item_amount += $charge;
            $item_name = $settings->title." Order";
 
        $orderData = [
            'receipt'         => $order->order_number,
            'amount'          => round($item_amount) * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
        $razorpayOrderId = $razorpayOrder['id'];
        
        session(['razorpay_order_id'=> $razorpayOrderId]);
                   
                    $order['method'] = "Razorpay";
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
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
        $order = Order::where( 'order_number', $order_id )->first();
         $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;

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
            $order = Order::where( 'order_number', $order_id )->first();

            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
                {
                    $data['status'] = 'completed';
                }
                $order->update($data);

            }
            return redirect(route('front.payment.success',1));

        }
        else
        {
            
            return redirect(route('front.checkout'));
        }
        
    }
    

}
