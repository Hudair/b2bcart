<?php

namespace App\Http\Controllers\Payment;
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
use App\Models\Order;
use App\Models\Cart;
use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\Package;

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
   
        if(!$request->has('order_number')){
             return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
        }
        
        $input = $request->all();
        
       
        $order_number = $request->order_number;
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
        $support = ['USD','EUR'];
        if(!in_array($curr->name,$support)){
            return redirect()->back()->with('unsuccess','Please Select USD Or EUR Currency For Paypal.');
        }
         
         
        
        $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
        $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
        
        $charge = $shipping + $packeging;
        $settings = Generalsetting::findOrFail(1);
        
        $item_amount = $order->pay_amount * $order->currency_value;
        $item_amount += $charge;
        
            
        $settings = Generalsetting::findOrFail(1);
        $order['item_name'] = $settings->title." Order";
        $order['item_amount'] = $item_amount;
        $notify_url = action('Payment\PaymentController@notify');
        $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;
        
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

 

     public function payreturn(Request $request){
         dd($request->all());
        $this->code_image();
        if(Session::has('tempcart')){
        $oldCart = Session::get('tempcart');
        $tempcart = new Cart($oldCart);
        $order = Session::get('temporder');
        }
        else{
            $tempcart = '';
            return redirect()->back();
        }
        Session::forget('cart');
        return view('front.success',compact('tempcart','order'));
     }

    public function notify(Request $request)
    {
    
        $paypal_data = Session::get('paypal_data');
        $order_data = Session::get('order_data');
        $success_url = action('Front\PaymentController@payreturn');
        $order = Order::where('order_number',$paypal_data['order_number'])->firstOrFail();
        $cancel_url = route('payment.checkout')."?order_number=".$order->order_number;
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
                
             
                 $order = Order::where('order_number',$paypal_data['order_number'])->firstOrFail();
                
                $shipping = Shipping::findOrFail($paypal_data['shipping'])->price * $order->currency_value;
                $packeging = Package::findOrFail($paypal_data['packeging'])->price * $order->currency_value;
                
                $charge = $shipping + $packeging;
                $settings = Generalsetting::findOrFail(1);
                $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
                $item_amount = $order->pay_amount * $order->currency_value;
                $item_amount += $charge;
             
                $order->packing_cost = $packeging;
                $order->shipping_cost = $shipping;
                $order->pay_amount = round($item_amount / $order->currency_value, 2);
                $order->method = "Paypal";
                $order->txnid = $resp['transactions'][0]['related_resources'][0]['sale']['id'];
                $order->payment_status = 'Completed';
                $order->save();
                return redirect(route('front.payment.success',1));
          
        }
        return redirect($cancel_url);
    }

    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

}