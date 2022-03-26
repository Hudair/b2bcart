<?php

namespace App\Http\Controllers\Api\Front;

use App\{
    Models\Reply,
    Models\Comment,
    Models\Product,
    Models\Rating
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\ReplyResource,
    Http\Resources\RatingResource,
    Http\Resources\CommentResource,
    Http\Resources\ProductDetailsResource
};

use Illuminate\Http\Request;

use Validator;

class ProductController extends Controller
{

    public function productDetails($id) {
      try{
      $product = Product::find($id);
      if(!$product){
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
      }
      return response()->json(['status' => true, 'data' => new ProductDetailsResource($product), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }
    
    public function ratings($id) {
      try{
      $product = Product::find($id);

      if(!$product){
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
      }
      $ratings = $product->ratings;

      return response()->json(['status' => true, 'data' => RatingResource::collection($ratings), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function comments($id) {
      try{
      $product = Product::find($id);
      if(!$product){
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
      }
      $comments = $product->comments()->orderBy('id', 'DESC')->get();
      return response()->json(['status' => true, 'data' => CommentResource::collection($comments), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function replies($id) {
      try{
      $comment = Comment::find($id);
      if(!$comment){
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Comment not found."]]);
      }
      $replies = $comment->replies()->orderBy('id', 'DESC')->get();
      return response()->json(['status' => true, 'data' => ReplyResource::collection($replies), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

}