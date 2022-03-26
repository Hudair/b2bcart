<?php

namespace App\Http\Controllers\User\Payment;

use App\Classes\GeniusMailer;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Deposit;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\User;
use App\Models\Pagesetting;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\Models\Transaction;
use Illuminate\Support\Str;

class AuthorizeController extends Controller
{

    public function store(Request $request){

    if(!$request->has('deposit_number')){
        return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
    }

            $settings = Generalsetting::findOrFail(1);
            $item_name = $settings->title." Deposit";
            $deposit_number = $request->deposit_number;
            $order = Deposit::where('deposit_number',$deposit_number)->first();
            $input = $request->all();
           
       
            $curr = Currency::where('name','=',$order->currency_code)->first();
            $item_amount = $order->amount ;
         
    

        $validator = Validator::make($request->all(),[
                        'cardNumber' => 'required',
                        'cardCode' => 'required',
                        'month' => 'required',
                        'year' => 'required',
                    ]);

        if ($validator->passes()) {

        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */

            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($settings->authorize_login_id);
            $merchantAuthentication->setTransactionKey($settings->authorize_txn_key);

            // Set the transaction's refId
            $refId = 'ref' . time();

            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($request->cardNumber);
            $year = $request->year;
            $month = $request->month;
            $creditCard->setExpirationDate($year.'-'.$month);
            $creditCard->setCardCode($request->cardCode);

            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);
        
            // Create order information
            $orders = new AnetAPI\OrderType();
            $orders->setInvoiceNumber($deposit_number);
            $orders->setDescription($item_name);

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction"); 
            $transactionRequestType->setAmount($item_amount);
            $transactionRequestType->setOrder($orders);
            $transactionRequestType->setPayment($paymentOne);
            // Assemble the complete transaction request
            $requestt = new AnetAPI\CreateTransactionRequest();
            $requestt->setMerchantAuthentication($merchantAuthentication);
            $requestt->setRefId($refId);
            $requestt->setTransactionRequest($transactionRequestType);
        
            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController($requestt);
            if($settings->authorize_mode == 'SANDBOX'){
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }
            else {
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);                
            }


            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();
                
                    if ($tresponse != null && $tresponse->getMessages() != null) {
                       
                        $order['method'] = $request->method;
                        $order['txnid'] = $tresponse->getTransId();
                        $order['status'] = 1;
                        $order->update();
                        
                 $user = User::findOrFail($order->user_id);
            $user->balance = $user->balance + $order->amount;
                $user->update();
                        
                               // store in transaction table
                    if ($order->status == 1) {
                        $transaction = new Transaction;
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
                        
                    } else {
                        return back()->with('unsuccess', 'Payment Failed.');
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    return back()->with('unsuccess', 'Payment Failed.');
                }      
            } else {
                return back()->with('unsuccess', 'Payment Failed.');
            }

        }
        return back()->with('unsuccess', 'Invalid Payment Details.');
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