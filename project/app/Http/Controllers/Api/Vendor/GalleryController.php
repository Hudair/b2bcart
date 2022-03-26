<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Product;
use App\Http\Resources\GalleryResource;
use Image;
use Auth;

class GalleryController extends Controller
{

    public function show($id)
    {
        try{
        $user = auth()->user();
        $prod = Product::find($id);
        if($user->id != $prod->user_id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This item is not your."]]);
        }
        if(!$prod){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
        }
        if(count($prod->galleries)){
            return response()->json(['status' => true, 'data' => GalleryResource::collection($prod->galleries), 'error' => []]);
        }else{
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "No Gallery Images Found."]]);
        }
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
             
    }  

    public function store(Request $request)
    { 
        try{
        $user = auth()->user();

        $lastid = $request->product_id;
        $prod = Product::find($lastid);

        if($user->id != $prod->user_id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This item is not your."]]);
        }

        if(!$prod){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
        }
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                $val = $file->getClientOriginalExtension();
                if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg')
                  {
                    $gallery = new Gallery;

                    $img = Image::make($file->getRealPath())->resize(800, 800);
                    $thumbnail = time().str_random(8).'.jpg';
                    $img->save(public_path().'/assets/images/galleries/'.$thumbnail);

                    $gallery['photo'] = $thumbnail;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();                     
                  }
            }
        }
        return response()->json(['status' => true, 'data' => GalleryResource::collection($prod->galleries), 'error' => []]); 
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }   
    } 

    public function destroy($id)
    {
        try{
        $user = auth()->user();
        $gal = Gallery::find($id);

        if($user->id != $gal->product->user_id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This item is not your."]]);
        }

        if(!$gal){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Image not found."]]);
        }

            if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                unlink(public_path().'/assets/images/galleries/'.$gal->photo);
            }
        $gal->delete();
        return response()->json(['status' => true, 'data' => ['message' => 'Image Deleted Successfully.'], 'error' => []]);  
        }
        catch(\Exception $e){
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
          }
    } 

}
