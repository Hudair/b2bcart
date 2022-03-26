<?php

namespace App\Http\Controllers\Api\User;

use App\{
    Models\User,
    Models\Message,
    Models\Pagesetting,
    Models\Notification,
    Models\Conversation,
    Classes\GeniusMailer,
    Models\Generalsetting,
    Http\Controllers\Controller,
    Http\Resources\ConversationResource,
    Http\Resources\ConversationMessageResource
};

use Validator;
use Illuminate\Http\Request;


class MessageController extends Controller
{

   public function messages()
    {
        try{
            return response()->json(['status' => true, 'data' => ConversationResource::collection(Conversation::where('sent_user',auth()->user()->id)->orWhere('recieved_user',auth()->user()->id)->with('messages')->get()), 'error' => []]);
          }
          catch(\Exception $e){
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    }


    //Send email to user
    public function usercontact(Request $request)
    {
        try{

            $rules =
            [
              'user_id' => 'required',
              'email' => 'required',
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
            $vendor = User::where('email','=',$request->email)->first();
            if(!$vendor){
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Email not found."]]);
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
                        $message->recieved_user = $vendor->id;
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



    public function postmessage(Request $request)
    {

        try{
        $user = auth()->user();
 
        $rules =
        [
          'conversation_id' => 'required',
          'sent_user' => [
            function ($attribute, $value, $fail) use ($request,$user) {
                if ($request->sent_user == $user->id) {
                  if (empty($request->sent_user)) {
                    $fail('sent_user id is required.');
                  }
                }
            },
           ],
           'recieved_user' => [
            function ($attribute, $value, $fail) use ($request,$user) {
                if ($request->recieved_user == $user->id) {
                  if (empty($request->recieved_user)) {
                    $fail('recieved_user id is required.');
                  }
                }
            },
           ],
          'message' => 'required'
 
        ];
 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $msg = new Message();
        $input = $request->all();  
     
        $mgs = $msg->fill($input)->save();
        //--- Redirect Section     
        return response()->json(['status' => true, 'data' => new ConversationMessageResource($msg), 'error' => []]);     
        //--- Redirect Section Ends  

    }
    catch(\Exception $e){
    return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
    }

    }


    public function messagedelete($id)
    {
            try{

            $conv = Conversation::find($id);
            if(!$conv){
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Conversation Not found."]]);
            }

            if($conv->messages->count() > 0)
            {
                foreach ($conv->messages as $key) {
                    $key->delete();
                }
            }

            $conv->delete();
            return response()->json(['status' => true, 'data' => ['message' => 'Message Deleted Successfully!'], 'error' => []]);   
            
            }
            catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
            }

    }












}
