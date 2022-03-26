<?php

namespace App\Http\Controllers\Payment;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Input;
use Redirect;
use Stripe\Error\Card;
use App\Models\Shipping;
use App\Models\Package;
use URL;
use Validator;

class StripeController extends Controller
{



  public function __construct()
    {
        //Set Spripe Keys
        $stripe = Generalsetting::findOrFail(1);
        Config::set('services.stripe.key', $stripe->stripe_key);
        Config::set('services.stripe.secret', $stripe->stripe_secret);
    }


    public function store(Request $request){
    
       

        if($request->has('order_number')){
            $order_number = $request->order_number;
            $order = Order::where('order_number',$order_number)->firstOrFail();
             $curr = Currency::where('sign','=',$order->currency_sign)->firstOrFail();
            if($curr->name != "USD"){
                 return redirect()->back()->with('unsuccess','Please Select USD Currency For Stripe.');
            }
            $input = $request->all();
            $shipping = Shipping::findOrFail($request->shipping)->price * $order->currency_value;
            $packeging = Package::findOrFail($request->packeging)->price * $order->currency_value;
            
            $charge = $shipping + $packeging;
            $settings = Generalsetting::findOrFail(1);
           
            $item_amount = $order->pay_amount * $order->currency_value;
            $item_amount += $charge;
            
            
            $item_name = $settings->title." Order";
            $validator = Validator::make($request->all(),[
                'cardNumber' => 'required',
                'cardCVC' => 'required',
                'month' => 'required',
                'year' => 'required',
            ]);
            
            
            if ($validator->passes()) {
    
                $stripe = Stripe::make(Config::get('services.stripe.secret'));
                try{
                    $token = $stripe->tokens()->create([
                        'card' =>[
                                'number' => $request->cardNumber,
                                'exp_month' => $request->month,
                                'exp_year' => $request->year,
                                'cvc' => $request->cardCVC,
                            ],
                        ]);
                    if (!isset($token['id'])) {
                        return back()->with('error','Token Problem With Your Token.');
                    }
    
                    $charge = $stripe->charges()->create([
                        'card' => $token['id'],
                        'currency' => $curr->name,
                        'amount' => $item_amount,
                        'description' => $item_name,
                        ]);
    
                    if ($charge['status'] == 'succeeded') {
                        $order->packing_cost = $packeging;
                        $order->shipping_cost = $shipping;
                        $order->pay_amount = round($item_amount / $order->currency_value, 2);
                        $order->method = "Stripe";
                        $order->txnid = $charge['balance_transaction'];
                        $order->charge_id = $charge['id'];
                        $order->payment_status = 'Completed';
                        $order->save();
                        return redirect(route('front.payment.success',1));
                    }
                    
                }catch (Exception $e){
                    // return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
                    $data = ['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]];
                    return redirect(route('front.payment.success',1));
                }catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
                     $data = ['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]];
                    return redirect(route('front.payment.success',0));
                     
                    // return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
                }catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
                     
                    return redirect(route('front.payment.success',0));
                    
                    ;
                }
            }            
            
            
        }
        
        
        return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Request']);
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
