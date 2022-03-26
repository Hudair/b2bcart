<?php

namespace App\Http\Controllers\Api\User;

use App\{
    Models\Order,
    Models\Reply,
    Models\Report,
    Models\Rating,
    Models\Product,
    Models\Comment
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\ReplyResource,
    Http\Resources\ReportResource,
    Http\Resources\RatingResource,
    Http\Resources\CommentResource,
    Http\Resources\ProductDetailsResource
};

use Illuminate\Http\Request;

use Validator;

class ProductController extends Controller
{

    public function reviewsubmit(Request $request)
    {
        try{
        $rules = [
            'user_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required',
            'comment' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $ck = 0;
        $orders = Order::where('user_id','=',$request->user_id)->where('status','=','completed')->get();

        foreach($orders as $order)
        {
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
            foreach($cart->items as $product)
            {
                if($request->product_id == $product['item']['id'])
                {
                    $ck = 1;
                    break;
                }
            }
        }
        if($ck == 1)
        {
            $user = auth()->user();
            $prev = Rating::where('product_id','=',$request->product_id)->where('user_id','=',$user->id)->get();
            if(count($prev) > 0)
            {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'You Have Reviewed Already.']]);
            }
            $Rating = new Rating;
            $in = $request->all();
            $in['review'] = $request->comment;
            $Rating->fill($in);
            $Rating['review_date'] = date('Y-m-d H:i:s');
            $Rating->save();

            return response()->json(['status' => true, 'data' => new RatingResource($Rating), 'error' => []]);
        }
        else {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Buy This Product First']]);
        }
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    public function commentstore(Request $request)
    {
        try{
        $rules = [
            'product_id' => 'required',
            'comment' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->product_id = $request->product_id;
        $comment->text = $request->comment;
        $comment->save();

        return response()->json(['status' => true, 'data' => new CommentResource($comment), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function commentupdate(Request $request)
    {
        try{
        $rules = [
            'id' => 'required',
            'comment' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $comment = Comment::find($request->id);
        $comment->text = $request->comment;
        $comment->save();

        return response()->json(['status' => true, 'data' => new CommentResource($comment), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function commentdelete($id)
    {
        try{
        $comment = Comment::find($id);
        if($comment->replies->count() > 0)
        {
            foreach ($comment->replies as $reply) {
                $reply->delete();
            }
        }
        $comment->delete();

        return response()->json(['status' => true, 'data' => ['message' => 'Comment Deleted Successfully!'], 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function replystore(Request $request)
    {
        try{
        $rules = [
            'comment_id' => 'required',
            'reply' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $reply = new Reply;
        $reply->user_id = auth()->user()->id;
        $reply->comment_id = $request->comment_id;
        $reply->text = $request->reply;
        $reply->save();

        return response()->json(['status' => true, 'data' => new ReplyResource($reply), 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function replyupdate(Request $request)
    {
        try{
        $rules = [
            'id' => 'required',
            'reply' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $reply = Reply::find($request->id);
        $reply->text = $request->reply;
        $reply->save();

        return response()->json(['status' => true, 'data' => new ReplyResource($reply), 'error' => []]);    
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function replydelete($id)
    {
        try{
        $reply = Reply::find($id);
        $reply->delete();

        return response()->json(['status' => true, 'data' => ['message' => 'Reply Deleted Successfully!'], 'error' => []]);
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function reportstore(Request $request)
    {
        try{

        //--- Validation Section
        $rules = [
          'product_id' => 'required',
          'title' => 'required',
          'note' => 'required|max:400',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
        $report = new Report;
        $report->user_id = auth()->user()->id;
        $report->product_id = $request->product_id;
        $report->title = $request->title;
        $report->note = $request->note;
        $report->save();
        //--- Logic Section Ends

        //--- Redirect Section
        return response()->json(['status' => true, 'data' => new ReportResource($report), 'error' => []]);  
        //--- Redirect Section Ends
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }
 
}