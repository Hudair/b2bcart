<?php

namespace App\Http\Controllers\User;


use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Auth;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class PaypalController extends Controller
{


 public function store(Request $request){
        $this->validate($request, [
            'shop_name'   => 'unique:users',
           ],[ 
               'shop_name.unique' => 'This shop name has already been taken.'
            ]);

            if (Session::has('currency')) 
            {
                $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
    
            $available_currency = ['USD','EUR'];
                
            if(!in_array($curr->name,$available_currency))
            {
            return redirect()->back()->with('unsuccess','Please Select USD Currency For Paypal.');
            }

            
    $user = Auth::user();
     $subs = Subscription::findOrFail($request->subs_id);
     $settings = Generalsetting::findOrFail(1);
     $paypal_email = $settings->paypal_business;
     $return_url = action('User\PaypalController@payreturn');
     $cancel_url = action('User\PaypalController@paycancle');
     $notify_url = action('User\PaypalController@notify');
     $item_name = $subs->title." Plan";
     $item_number = Str::random(10);
     $item_amount = $subs->price;

     //return $item_amount;

     $querystring = '';

     // Firstly Append paypal account to querystring
     $querystring .= "?business=".urlencode($paypal_email)."&";

     // Append amount& currency (£) to quersytring so it cannot be edited in html

     //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
     $querystring .= "item_name=".urlencode($item_name)."&";
     $querystring .= "amount=".urlencode($item_amount)."&";
     $querystring .= "item_number=".urlencode($item_number)."&";

    $querystring .= "cmd=".urlencode(stripslashes($request->cmd))."&";
    $querystring .= "bn=".urlencode(stripslashes($request->bn))."&";
    $querystring .= "lc=".urlencode(stripslashes($request->lc))."&";
    $querystring .= "currency_code=".urlencode(stripslashes($request->currency_code))."&";

     // Append paypal return addresses
     $querystring .= "return=".urlencode(stripslashes($return_url))."&";
     $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
     $querystring .= "notify_url=".urlencode($notify_url)."&";

     $querystring .= "custom=".$user->id;
    // Redirect to paypal IPN


                    $sub = new UserSubscription;
                    $sub->user_id = $user->id;
                    $sub->subscription_id = $subs->id;
                    $sub->title = $subs->title;
                    $sub->currency = $subs->currency;
                    $sub->currency_code = $subs->currency_code;
                    $sub->price = $subs->price;
                    $sub->days = $subs->days;
                    $sub->allowed_products = $subs->allowed_products;
                    $sub->details = $subs->details;
                    $sub->method = 'Paypal';
                    $sub->save();

     return redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring);
     //header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);

 }


     public function paycancle(){
         return redirect()->back()->with('unsuccess','Payment Cancelled.');
     }

     public function payreturn(){
         return redirect()->route('user-dashboard')->with('success','Vendor Account Activated Successfully');
     }


public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    //return $myPost;


    // Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $order = UserSubscription::where('user_id','=',$_POST['custom'])
            ->orderBy('created_at','desc')->first();


        $user = User::findOrFail($_POST['custom']);
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($order->subscription_id);
        $settings = Generalsetting::findOrFail(1);


        $today = Carbon::now()->format('Y-m-d');
        $date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
        $input = $request->all();
        $user->is_vendor = 2;
        if(!empty($package))
        {
            if($package->subscription_id == $request->subs_id)
            {
                $newday = strtotime($today);
                $lastday = strtotime($user->date);
                $secs = $lastday-$newday;
                $days = $secs / 86400;
                $total = $days+$subs->days;
                $user->date = date('Y-m-d', strtotime($today.' + '.$total.' days'));
            }
            else
            {
                $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
            }
        }
        else
        {
            $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
        }
        $user->mail_sent = 1;
        $user->update($input);


        $data['txnid'] = $_POST['txn_id'];
        $data['status'] = 1;
        $order->update($data);

        if($settings->is_smtp == 1)
        {
            $maildata = [
                'to' => $user->email,
                'type' => "vendor_accept",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($maildata);
        }
        else
        {
            $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
            mail($user->email,'Your Vendor Account Activated','Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.',$headers);
        }


    }else{
        $payment = UserSubscription::where('user_id','=',$_POST['custom'])
            ->orderBy('created_at','desc')->first();
        $payment->delete();


    }
}

}
