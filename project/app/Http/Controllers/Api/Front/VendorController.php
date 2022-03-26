<?php

namespace App\Http\Controllers\Api\Front;

use App\{
    Models\User,
    Models\Message,
    Models\Product,
    Models\Category,
    Models\Subcategory,
    Models\Conversation,
    Classes\GeniusMailer,
    Models\Childcategory,
    Models\Generalsetting,
    Http\Controllers\Controller,
    Http\Resources\VendorResource,
    Http\Resources\ServiceResource,
    Http\Resources\ProductlistResource,
    
};

use Illuminate\{
    Http\Request,
    Support\Facades\DB,
    Support\Collection
};

use Validator;

class VendorController extends Controller
{

    public function index(Request $request,$shop_name)
    {
        try{
        $minprice = $request->min;
        $maxprice = $request->max;
        $sort = $request->sort;
        $string = str_replace('-',' ', $shop_name);
        $vendor = User::where('shop_name','=',$string)->first();
        if(!$vendor){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Shop name not found."]]);
          }
        $data['vendor'] = new VendorResource($vendor);
        $services = DB::table('services')->where('user_id','=',$vendor->id)->get();
        $data['services'] = ServiceResource::collection($services);


        // Search By Price
        $prods = Product::when($minprice, function($query, $minprice) {
                                      return $query->where('price', '>=', $minprice);
                                    })
                                    ->when($maxprice, function($query, $maxprice) {
                                      return $query->where('price', '<=', $maxprice);
                                    })
                                     ->when($sort, function ($query, $sort) {
                                        if ($sort=='date_desc') {
                                          return $query->orderBy('id', 'DESC');
                                        }
                                        elseif($sort=='date_asc') {
                                          return $query->orderBy('id', 'ASC');
                                        }
                                        elseif($sort=='price_desc') {
                                          return $query->orderBy('price', 'DESC');
                                        }
                                        elseif($sort=='price_asc') {
                                          return $query->orderBy('price', 'ASC');
                                        }
                                     })
                                    ->when(empty($sort), function ($query, $sort) {
                                        return $query->orderBy('id', 'DESC');
                                    })->where('status', 1)->where('user_id', $vendor->id)->get();

        $vprods = (new Collection(Product::filterProducts($prods)));
        $data['products'] = ProductlistResource::collection($vprods);

        return response()->json(['status' => true, 'data' => $data, 'error' => []]);
        }
        catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    //Send email to user
    public function vendorcontact(Request $request)
    {

        try{

        $rules =
        [
          'user_id' => 'required',
          'vendor_id' => 'required',
          'subject' => 'required',
          'message' => 'required'
 
        ];
 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "User not found."]]);
        }
        $vendor = User::find($request->vendor_id);
        if(!$vendor){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Vendor not found."]]);
        }


        $gs = Generalsetting::find(1);
            $subject = $request->subject;
            $to = $vendor->email;
            $name = $user->name;
            $from = $user->email;
            $msg = "Name: ".$name."\nEmail: ".$from."\nMessage: ".$request->message;
            if($gs->is_smtp)
            {
                $data = [
                    'to' => $to,
                    'subject' => $subject,
                    'body' => $msg,
                ];

                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($data);
            }
            else{
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($to,$subject,$msg,$headers);
            }


            $conv = Conversation::where('sent_user','=',$user->id)->where('subject','=',$subject)->first();
                if(isset($conv)){
                    $msg = new Message();
                    $msg->conversation_id = $conv->id;
                    $msg->message = $request->message;
                    $msg->sent_user = $user->id;
                    $msg->save();
                }
                else{
                    $message = new Conversation();
                    $message->subject = $subject;
                    $message->sent_user= $request->user_id;
                    $message->recieved_user = $request->vendor_id;
                    $message->message = $request->message;
                    $message->save();
                    $msg = new Message();
                    $msg->conversation_id = $message->id;
                    $msg->message = $request->message;
                    $msg->sent_user = $request->user_id;;
                    $msg->save();

                }

            return response()->json(['status' => true, 'data' => ["message" => "Message Sent Successfully!"], 'error' => []]);


        }
        catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }

    }

 
}
