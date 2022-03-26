<?php

namespace App\Http\Controllers\Api\Vendor;

use App\{
    Models\Product,
    Models\Gallery,
    Models\Category,
    Models\Currency,
    Models\Attribute,
    Models\Subcategory,
    Models\Childcategory,
    Models\AttributeOption,
    Http\Controllers\Controller,
    Http\Resources\ProductlistResource,
    Http\Resources\ProductDetailsResource
};

use Illuminate\{
    Http\Request,
    Validation\Rule,
    Support\Facades\Input
};

use DB;
use Auth;
use Image;
use Session;
use Validator;
use Datatables;


class ProductController extends Controller
{

    // Display All Type Of Products 

    public function index(Request $request) {
        try{
        $input = $request->all();
        $user = auth()->user();

        if(!empty($input)){
  
        $type              = isset($input['type']) ? $input['type'] : '';
        $typeCheck         = !empty($type) && in_array($type, ['Physical','Digital','License']);
        $highlight         = isset($input['highlight']) ? $input['highlight'] : '';
        $highlightCheck    = !empty($highlight) && in_array($highlight, ['featured','best','top','big','is_discount','hot','latest','trending','sale']);
        $productType       = isset($input['product_type']) ? $input['product_type'] : '';
        $productTypeCheck  = !empty($productType) && in_array($productType, ['normal','affiliate']);
        $catalog           = isset($input['catalog']) ? $input['catalog'] : '';
        $catalogCheck      = !empty($catalog) && $catalog == 'true';
        $limit             = isset($input['limit']) ? (int)$input['limit'] : 0;
  
        $prods = Product::whereUserId($user->id);
  
        if($typeCheck){
          $prods = $prods->whereType($type);
        }
  
        if($productTypeCheck){
          $prods = $prods->whereProductType($productType);
        }
  
        if($highlightCheck){
          if($highlight == 'featured'){
            $prods = $prods->whereFeatured(1);
          }else if($highlight == 'best'){
            $prods = $prods->whereBest(1);
          }else if($highlight == 'top'){
            $prods = $prods->whereTop(1);
          }else if($highlight == 'big'){
            $prods = $prods->whereBig(1);
          }else if($highlight == 'is_discount'){
            $prods = $prods->whereIsDiscount(1);
          }else if($highlight == 'hot'){
            $prods = $prods->whereHot(1);
          }else if($highlight == 'latest'){
            $prods = $prods->whereLatest(1);
          }else if($highlight == 'trending'){
            $prods = $prods->whereTrending(1);
          }else{
            $prods = $prods->whereSale(1);
          }        
        }
  
        if($limit == 0){
          $prods = $prods->get();
        }else{
          $prods = $prods->take($limit)->get();
        }

        if($catalogCheck){
            return response()->json(['status' => true, 'data' => ProductlistResource::collection($prods), 'error' => []]);
        }else{
            $datas =  Product::where('product_type','normal')->where('status','=',1)->where('is_catalog','=',1)->orderBy('id','desc')->get();
            return response()->json(['status' => true, 'data' => ProductlistResource::collection($datas), 'error' => []]);
        }

        }else{
  
          $prods = Product::whereUserId($user->id)->get();
          return response()->json(['status' => true, 'data' => ProductlistResource::collection($prods), 'error' => []]);
  
        }
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
      }
      
      

  
    // Display All Type Of Products Ends
      
    //*** GET Request
    public function status($id1,$id2)
    {
      try{
        $user = auth()->user();
        $data = Product::findOrFail($id1);
        if($data->user_id == $user->id){
            $data->status = $id2;
            $data->update();
            return response()->json(['status' => true, 'data' => ['message' => 'Status Updated Successfully.'], 'error' => []]);
        }else{
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This item is not your.']]);
        }
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }
    


    //*** GET Request
    public function formInput(Request $request)
    {
  
        if($request->type == 'Physical')
        {
            $input = '[{
                
                "type" : "Physical",
                 "data":[
                 {
                   "label": "Product Name",
    				"type": "text",
    				"key": "name"
                },
                 {
                   "label": "Product Sku",
    				"type": "text",
    				"key": "sku"
                },
                 {
                   "label": "Allow Product Condition",
    				"type": "checkbox",
    				"key": "product_condition_check"
                },
                {
                   "label": "Product Condition",
    				"type": "selectbox",
    				"key": "product_condition"
                },
                 {
                   "label": "Category",
    				"type": "selectbox",
    				"key": "category_id"
                },
                 {
                   "label": "Sub Category",
    				"type": "selectbox",
    				"key": "subcategory_id"
                },
                 {
                   "label": "Child Category",
    				"type": "selectbox",
    				"key": "childcategory_id"
                },
                 
                 {
                   "label": "Current Featured Image",
    				"type": "file",
    				"key": "photo"
                },
                 {
                   "label": "Allow Estimated Shipping Time",
    				"type": "checkbox",
    				"key": "shipping_time_check"
                },
                 {
                   "label": "Product Estimated Shipping Time",
    				"type": "text",
    				"key": "ship"
                },
                 {
                   "label": "Allow Product Sizes",
    				"type": "checkbox",
    				"key": "size_check"
                },
                 {
                   "label": "Size Name",
    				"type": "text",
    				"key": "size[]"
                },
                 {
                   "label": "Size Qty",
    				"type": "text",
    				"key": "size_qty[]"
                },
                 {
                   "label": "Size Price",
    				"type": "text",
    				"key": "size_price[]"
                },
                 {
                   "label": "Allow Product Colors",
    				"type": "checkbox",
    				"key": "color_check"
                },
                 {
                   "label": "Product Colors",
    				"type": "text",
    				"key": "color[]"
                },
                 {
                   "label": "Allow Product Whole Sell",
    				"type": "checkbox",
    				"key": "whole_check"
                },
                 {
                   "label": "Enter Quantity",
    				"type": "text",
    				"key": "whole_sell_qty[]"
                },
                 {
                   "label": "Enter Discount Percentage",
    				"type": "text",
    				"key": "whole_sell_discount[]"
                },
                 {
                   "label": "Product Current Price",
    				"type": "text",
    				"key": "price"
                },
                 {
                   "label": "Product Previous Price",
    				"type": "text",
    				"key": "previous_price"
                },
                 {
                   "label": "Product Stock",
    				"type": "text",
    				"key": "stock"
                },
                 {
                   "label": "Allow Product Measurement",
    				"type": "selectbox",
    				"key": "measure_check"
                },
                 {
                   "label": "Product Measurement",
    				"type": "selectbox",
    				"key": "measure"
                },
                 {
                   "label": "Product Description",
    				"type": "textarea",
    				"key": "details"
                },
                 {
                   "label": "Product Buy/Return Policy",
    				"type": "textarea",
    				"key": "policy"
                },
                 {
                   "label": "Youtube Video URL",
    				"type": "text",
    				"key": "youtube"
                },
                 {
                   "label": "Allow Product SEO",
    				"type": "checkbox",
    				"key": "seo_check"
                },
                 {
                   "label": "Meta Tags",
    				"type": "text",
    				"key": "meta_tag[]"
                },
                 {
                   "label": "Meta Description",
    				"type": "textarea",
    				"key": "meta_description[]"
                },
                 {
                   "label": "Feature Keyword",
    				"type": "text",
    				"key": "features[]"
                },
                 {
                   "label": "Feature Color",
    				"type": "text",
    				"key": "colors[]"
                },
                 {
                   "label": "Tags ",
    				"type": "text",
    				"key": "tags[]"
                },
                 {
                   "label": "",
    				"type": "hidden",
    				"key": "type"
                }
                ]
             
                
            }]';  
            
            $response = json_decode($input,true);
            return response()->json(['status' => true, 'data' => $response, 'error' => []]);
        }
        elseif($request->type == 'Digital'){
            
            
             $input = '[{
                
                "type" : "Digital",
                 "data":[
                {
                   "label": "Product Name",
    				"type": "text",
    				"key": "name"
                },
                 {
                   "label": "Product Sku",
    				"type": "text",
    				"key": "sku"
                },
                {
                   "label": "Category",
    				"type": "selectbox",
    				"key": "category_id"
                },
                 {
                   "label": "Sub Category",
    				"type": "selectbox",
    				"key": "subcategory_id"
                },
                 {
                   "label": "Child Category",
    				"type": "selectbox",
    				"key": "childcategory_id"
                },
                 {
                   "label": "Select Upload Type",
    				"type": "selectbox",
    				"key": "type_check"
                },
                 {
                   "label": "Select File",
    				"type": "file",
    				"key": "file"
                },
                 {
                   "label": "Link",
    				"type": "text",
    				"key": "link"
                },
                 
                 {
                   "label": "Current Featured Image",
    				"type": "file",
    				"key": "photo"
                },
                
                 {
                   "label": "Product Current Price",
    				"type": "text",
    				"key": "price"
                },
                 {
                   "label": "Product Previous Price",
    				"type": "text",
    				"key": "previous_price"
                },
                 
                 {
                   "label": "Product Description",
    				"type": "textarea",
    				"key": "details"
                },
                 {
                   "label": "Product Buy/Return Policy",
    				"type": "textarea",
    				"key": "policy"
                },
                 {
                   "label": "Youtube Video URL",
    				"type": "text",
    				"key": "youtube"
                },
                 {
                   "label": "Allow Product SEO",
    				"type": "checkbox",
    				"key": "seo_check"
                },
                 {
                   "label": "Meta Tags",
    				"type": "text",
    				"key": "meta_tag[]"
                },
               
                 {
                   "label": "Meta Description",
    				"type": "textarea",
    				"key": "meta_description[]"
                },
                 {
                   "label": "Feature Keyword",
    				"type": "text",
    				"key": "features[]"
                },
                 {
                   "label": "Feature Color",
    				"type": "text",
    				"key": "colors[]"
                },
                 {
                   "label": "Tags ",
    				"type": "text",
    				"key": "tags[]"
                },
                 {
                   "label": "",
    				"type": "hidden",
    				"key": "type"
                }
                ]
             
                
            }]';  
            
            $response = json_decode($input,true);
            return response()->json(['status' => true, 'data' => $response, 'error' => []]);
            
        
            
        }
        
        elseif($request->type == 'License'){
      
      
        $input = '[{
                
                "type" : "License",
                 "data":[
                {
                   "label": "Product Name",
    				"type": "text",
    				"key": "name"
                },
                 {
                   "label": "Product Sku",
    				"type": "text",
    				"key": "sku"
                },
                 {
                   "label": "Category",
    				"type": "selectbox",
    				"key": "category_id"
                },
                 {
                   "label": "Sub Category",
    				"type": "selectbox",
    				"key": "subcategory_id"
                },
                 {
                   "label": "Child Category",
    				"type": "selectbox",
    				"key": "childcategory_id"
                },
                 {
                   "label": "Select Upload Type",
    				"type": "selectbox",
    				"key": "type_check"
                },
                 {
                   "label": "Select File",
    				"type": "file",
    				"key": "file"
                },
                 {
                   "label": "Link",
    				"type": "text",
    				"key": "link"
                },
                 
                 {
                   "label": "Current Featured Image",
    				"type": "file",
    				"key": "photo"
                },
               
                 
                {
                   "label": "Product Current Price",
    				"type": "text",
    				"key": "price"
                },
                 {
                   "label": "Product Previous Price",
    				"type": "text",
    				"key": "previous_price"
                },
                 {
                   "label": "Product License Key",
    				"type": "text",
    				"key": "license[]"
                },
                 {
                   "label": "Product License Quantity",
    				"type": "text",
    				"key": "license_qty[]"
                },
                 
                 {
                   "label": "Product Description",
    				"type": "textarea",
    				"key": "details"
                },
                 {
                   "label": "Product Buy/Return Policy",
    				"type": "textarea",
    				"key": "policy"
                },
                 {
                   "label": "Youtube Video URL",
    				"type": "text",
    				"key": "youtube"
                },
                 {
                   "label": "Allow Product SEO",
    				"type": "checkbox",
    				"key": "seo_check"
                },
                 {
                   "label": "Meta Tags",
    				"type": "text",
    				"key": "meta_tag[]"
                },
               
                 {
                   "label": "Meta Description",
    				"type": "textarea",
    				"key": "meta_description[]"
                },
                 {
                   "label": "Feature Keyword",
    				"type": "text",
    				"key": "features[]"
                },
                 {
                   "label": "Feature Color",
    				"type": "text",
    				"key": "colors[]"
                },
                 {
                   "label": "Tags",
    				"type": "text",
    				"key": "tags[]"
                },
                 {
                   "label": "Product Platform",
    				"type": "text",
    				"key": "platform"
                },
                 {
                   "label": "Product Region",
    				"type": "text",
    				"key": "region"
                },
                 {
                   "label": "License Type",
    				"type": "text",
    				"key": "license_type"
                },
                 {
                   "label": "",
    				"type": "hidden",
    				"key": "type"
                }
                ]
             
                
            }]';  
            
            $response = json_decode($input,true);
            return response()->json(['status' => true, 'data' => $response, 'error' => []]);
            
                  
        }elseif($request->type == 'Affiliate'){
            
                   $input = '[{
                
                "type" : "Affiliate",
                 "data":[
                {
                   "label": "Product Name",
    				"type": "text",
    				"key": "name"
                },
                 {
                   "label": "Product Sku",
    				"type": "text",
    				"key": "sku"
                },
                 {
                   "label": "Product Affiliate Link",
    				"type": "text",
    				"key": "affiliate_link"
                },
                 {
                   "label": "Allow Product Condition",
    				"type": "checkbox",
    				"key": "product_condition_check"
                },
                 {
                   "label": "Allow Product Condition",
    				"type": "selectbox",
    				"key": "product_condition_check"
                },
                 {
                   "label": "Category",
    				"type": "selectbox",
    				"key": "category_id"
                },
                 {
                   "label": "Sub Category",
    				"type": "selectbox",
    				"key": "subcategory_id"
                },
                 {
                   "label": "Child Category",
    				"type": "selectbox",
    				"key": "childcategory_id"
                },

                 {
                   "label": "Feature Image Source",
    				"type": "selectbox",
    				"key": "image_source"
                },
                 
                {
                   "label": "Current Featured Image",
    				"type": "text",
    				"key": "photo"
                },
                {
                   "label": "Feature Image Link",
    				"type": "text",
    				"key": "photolink"
                },
                {
                   "label": "Allow Estimated Shipping Time",
    				"type": "checkbox",
    				"key": "shipping_time_check"
                },
                 {
                   "label": "Product Estimated Shipping Time",
    				"type": "text",
    				"key": "ship"
                },
                 {
                   "label": "Allow Product Sizes",
    				"type": "checkbox",
    				"key": "size_check"
                },
                 {
                   "label": "Size Name",
    				"type": "text",
    				"key": "size[]"
                },
                 {
                   "label": "Size Qty",
    				"type": "text",
    				"key": "size_qty[]"
                },
                 {
                   "label": "Size Price",
    				"type": "text",
    				"key": "size_price[]"
                },
                 {
                   "label": "Allow Product Colors",
    				"type": "checkbox",
    				"key": "color_check"
                },
                 {
                   "label": "Product Colors",
    				"type": "text",
    				"key": "color[]"
                },
                {
                   "label": "Product Current Price",
    				"type": "text",
    				"key": "price"
                },
                 {
                   "label": "Product Previous Price",
    				"type": "text",
    				"key": "previous_price"
                },
                 {
                   "label": "Product Stock",
    				"type": "text",
    				"key": "stock"
                },
                 
                 {
                   "label": "Product Description",
    				"type": "textarea",
    				"key": "details"
                },
                 {
                   "label": "Product Buy/Return Policy",
    				"type": "textarea",
    				"key": "policy"
                },
                 {
                   "label": "Youtube Video URL",
    				"type": "text",
    				"key": "youtube"
                },
                 {
                   "label": "Allow Product SEO",
    				"type": "checkbox",
    				"key": "seo_check"
                },
                 {
                   "label": "Meta Tags",
    				"type": "text",
    				"key": "meta_tag[]"
                },
               
                 {
                   "label": "Meta Description",
    				"type": "textarea",
    				"key": "meta_description[]"
                },
                 {
                   "label": "Feature Keyword",
    				"type": "text",
    				"key": "features[]"
                },
                 {
                   "label": "Feature Color",
    				"type": "text",
    				"key": "colors[]"
                },
                 {
                   "label": "Tags",
    				"type": "text",
    				"key": "tags[]"
                },
        
                 {
                   "label": "",
    				"type": "hidden",
    				"key": "type"
                }
                ]
             
                
            }]';  
            
            $response = json_decode($input,true);
            return response()->json(['status' => true, 'data' => $response, 'error' => []]);
            
            
            
        }

        
        $response = json_decode($input,true);
        
        return response()->json(['status' => true, 'data' => $response, 'error' => []]);
        
    }


    //*** POST Request
    public function store(Request $request)
    {
        
       
        try{
        $user = auth()->user();
        if(count($user->subscribes) == 0){
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Please purchase a subscription plan.']]);
        }
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();

        if($prods < $package->allowed_products || $package->allowed_products == 0)
        {

        //--- Validation Section
        $rules = [
               'name'         => 'required',
               'price'        => 'required',
               'file'         => 'mimes:zip',
            //   'photo'        => 'mimes:jpeg,jpg,png,svg',
               'type'         => [
                                'required',
                                Rule::in(['Physical', 'Digital', 'License']),
                                 ],
               'product_type' => [
                                'required',
                                Rule::in(['normal', 'affiliate']),
                                 ],
                ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
            $data = new Product;
            $sign = Currency::where('is_default','=',1)->first();
            $input = $request->all();
            // Check File
            if ($file = $request->file('file'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/files',$name);
                $input['file'] = $name;
            }

            if ($file = $request->file('photo')) 
            {      
               $name = time().str_replace(' ', '', $file->getClientOriginalName());
               $file->move('assets/images/products',$name);           
               $input['photo'] = $name;
            } 
            
              // Check Size

                if(empty($request->size_check ))
                {
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                }
                else{
                        if(in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price))
                        {
                            $input['size'] = null;
                            $input['size_qty'] = null;
                            $input['size_price'] = null;
                        }
                        else
                        {
                            $input['size'] = implode(',', $request->size);
                            $input['size_qty'] = implode(',', $request->size_qty);
                            $input['size_price'] = implode(',', $request->size_price);
                        }
                }

       

                // Check Color

                if(empty($request->color_check ))
                {
                    $input['color'] = null;
                }
                else{
                    if (!empty($request->color))
                     {
                        $input['color'] = implode(',', $request->color);
                     }
                    if (empty($request->color))
                     {
                        $input['color'] = null;
                     }
                }

            // Check Physical
            if($request->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku'      => 'min:8|unique:products'];

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                      return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
                    }
                    //--- Validation Section Ends


            // Check Condition
            if ($request->product_condition_check == ""){
                $input['product_condition'] = 0;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            
            
    

            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

           
            // Check Measurement
            if ($request->mesasure_check == "")
             {
                $input['measure'] = null;
             }

            }
  
            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }

             // Check License

            if($request->type == "License")
            {

                if(in_array(null, $request->license) || in_array(null, $request->license_qty))
                {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                }
                else
                {
                    $input['license'] = implode(',,', $request->license);
                    $input['license_qty'] = implode(',', $request->license_qty);
                }

            }

            // Check Features
            if($request->features){
                if(in_array(null, $request->features) || in_array(null, $request->colors))
                {
                    $input['features'] = null;
                    $input['colors'] = null;
                }
                else
                {
                    $input['features'] = implode(',', str_replace(',',' ',$request->features));
                    $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
                }
            }
 

            //tags
            if (!empty($request->tags))
             {
                $input['tags'] = implode(',', $request->tags);
             }

            // Conert Price According to Currency
            if($request->price){
             $input['price'] = ($input['price'] / $sign->value);
            }
            if($request->previous_price){
             $input['previous_price'] = ($input['previous_price'] / $sign->value);
            }
            
           

            $input['user_id'] = $user->id;

           // store filtering attributes for physical product
           $attrArr = [];
           if (!empty($request->category_id)) {
             $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
             if (!empty($catAttrs)) {
               foreach ($catAttrs as $key => $catAttr) {
                 $in_name = $catAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($catAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }

           if (!empty($request->subcategory_id)) {
             $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
             if (!empty($subAttrs)) {
               foreach ($subAttrs as $key => $subAttr) {
                 $in_name = $subAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($subAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }
           
           if (!empty($request->childcategory_id)) {
             $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
             if (!empty($childAttrs)) {
               foreach ($childAttrs as $key => $childAttr) {
                 $in_name = $childAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($childAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }

           if (empty($attrArr)) {
             $input['attributes'] = NULL;
           } else {
             $jsonAttr = json_encode($attrArr);
             $input['attributes'] = $jsonAttr;
           }


            // Save Data
         
                $data->fill($input)->save();


            // Set SLug

                $prod = Product::find($data->id);
                if($prod->type != 'Physical'){
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower(str_random(3).$data->id.str_random(3));
                }
                else {
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
                }
                // Set Photo
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(800, null, function ($c) {
                    $c->aspectRatio();
                });
                $photo = time().str_random(8).'.jpg';
                $resizedImage->save(public_path().'/assets/images/products/'.$photo);

                // Set Thumbnail
                $background = Image::canvas(300, 300);
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(300, 300, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                // insert resized image centered into background
                $background->insert($resizedImage, 'center');
                // save or do whatever you like
                $thumbnail = time().str_random(8).'.jpg';
                $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);

                $prod->thumbnail  = $thumbnail;
                $prod->photo  = $photo;
                $prod->update();

            //logic Section Ends

            //--- Redirect Section
            return response()->json(['status' => true, 'data' => new ProductDetailsResource($prod), 'error' => []]);
            //--- Redirect Section Ends
        }
        else
        {
            //--- Redirect Section
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'You Can\'t Add More Product.']]);
            //--- Redirect Section Ends
        }
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }



    //*** POST Request
    public function update(Request $request, $id)
    {
      try{
       $user = auth()->user();

        //--- Validation Section
        $rules = [
               'photo'      => 'mimes:jpeg,jpg,png,svg',
               'file'       => 'mimes:zip'
                ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //-- Logic Section

        $data = Product::findOrFail($id);

        $user = auth()->user();
        if($data->user_id != $user->id){
            return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This item is not your.']]);
        }

        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        if ($file = $request->file('photo')) 
        {              
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/products',$name);
            if($data->photo != null)
            {
                if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                    unlink(public_path().'/assets/images/products/'.$data->photo);
                }
            }            
        $input['photo'] = $name;
        } 
            //Check Types
            if($request->type_check == 1)
            {
                $input['link'] = null;
            }
            else
            {
                if($data->file!=null){
                        if (file_exists(public_path().'/assets/files/'.$data->file)) {
                        unlink(public_path().'/assets/files/'.$data->file);
                    }
                }
                $input['file'] = null;
            }
            
            
            // Check Size

                        if(empty($request->size_check ))
                        {
                            $input['size'] = null;
                            $input['size_qty'] = null;
                            $input['size_price'] = null;
                        }
                        else{
                                if(in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price))
                                {
                                    $input['size'] = null;
                                    $input['size_qty'] = null;
                                    $input['size_price'] = null;
                                }
                                else
                                {
                                    $input['size'] = implode(',', $request->size);
                                    $input['size_qty'] = implode(',', $request->size_qty);
                                    $input['size_price'] = implode(',', $request->size_price);
                                }
                        }


                        // Check Color

                        if(empty($request->color_check ))
                        {
                            $input['color'] = null;
                        }
                        else{
                            if (!empty($request->color))
                             {
                                $input['color'] = implode(',', $request->color);
                             }
                            if (empty($request->color))
                             {
                                $input['color'] = null;
                             }
                        }

            // Check Physical
            if($data->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku' => 'min:8|unique:products,sku,'.$id];

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                      return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
                    }
                    //--- Validation Section Ends

                        // Check Condition
                        if ($request->product_condition_check == ""){
                            $input['product_condition'] = 0;
                        }

                        // Check Shipping Time
                        if ($request->shipping_time_check == ""){
                            $input['ship'] = null;
                        }

                        
            // Check Whole Sale

            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

                        // Check Color

                        if(empty($request->color_check ))
                        {
                            $input['color'] = null;
                        }
                        else{
                            if (!empty($request->color))
                             {
                                $input['color'] = implode(',', $request->color);
                             }
                            if (empty($request->color))
                             {
                                $input['color'] = null;
                             }
                        }

                        // Check Measure
                    if ($request->measure_check == "")
                     {
                        $input['measure'] = null;
                     }
            }

        // Check Seo

        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }

        // Check License

        if($data->type == "License")
        {

          if(!in_array(null, $request->license) && !in_array(null, $request->license_qty))
          {
              $input['license'] = implode(',,', $request->license);
              $input['license_qty'] = implode(',', $request->license_qty);
          }
          else
          {
              if(in_array(null, $request->license) || in_array(null, $request->license_qty))
              {
                  $input['license'] = null;
                  $input['license_qty'] = null;
              }
              else
              {
                  $license = explode(',,', $prod->license);
                  $license_qty = explode(',', $prod->license_qty);
                  $input['license'] = implode(',,', $license);
                  $input['license_qty'] = implode(',', $license_qty);
              }
          }

        }
            // Check Features

            if($request->features){

              if(!in_array(null, $request->features) && !in_array(null, $request->colors))
              {
                      $input['features'] = implode(',', str_replace(',',' ',$request->features));
                      $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
              }
              else
              {
                  if(in_array(null, $request->features) || in_array(null, $request->colors))
                  {
                      $input['features'] = null;
                      $input['colors'] = null;
                  }
                  else
                  {
                      $features = explode(',', $data->features);
                      $colors = explode(',', $data->colors);
                      $input['features'] = implode(',', $features);
                      $input['colors'] = implode(',', $colors);
                  }
              }
           }
        //Product Tags
        if (!empty($request->tags))
         {
            $input['tags'] = implode(',', $request->tags);
         }
        if (empty($request->tags))
         {
            $input['tags'] = null;
         }

         if($request->price){
          $input['price'] = ($input['price'] / $sign->value);
         }

         if($request->previous_price){
          $input['previous_price'] = ($input['previous_price'] / $sign->value);
         }

         $input['user_id'] = $user->id;

         // store filtering attributes for physical product
         $attrArr = [];
         if (!empty($request->category_id)) {
           $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
           if (!empty($catAttrs)) {
             foreach ($catAttrs as $key => $catAttr) {
               $in_name = $catAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($catAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }

         if (!empty($request->subcategory_id)) {
           $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
           if (!empty($subAttrs)) {
             foreach ($subAttrs as $key => $subAttr) {
               $in_name = $subAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($subAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }

         if (!empty($request->childcategory_id)) {
           $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
           if (!empty($childAttrs)) {
             foreach ($childAttrs as $key => $childAttr) {
               $in_name = $childAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($childAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }

         if (empty($attrArr)) {
           $input['attributes'] = NULL;
         } else {
           $jsonAttr = json_encode($attrArr);
           $input['attributes'] = $jsonAttr;
         }


          $data->update($input);

         
        //-- Logic Section Ends

        $prod = Product::find($data->id);

        // Set SLug
        $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);

        // Set Photo
        $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(800, null, function ($c) {
          $c->aspectRatio();
        });
        $photo = time().str_random(8).'.jpg';
        $resizedImage->save(public_path().'/assets/images/products/'.$photo);

        // Set Thumbnail
        $background = Image::canvas(300, 300);
        $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(300, 300, function ($c) {
          $c->aspectRatio();
          $c->upsize();
        });

        // insert resized image centered into background
        $background->insert($resizedImage, 'center');

        // save or do whatever you like
        $thumbnail = time().str_random(8).'.jpg';
        $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
        $prod->thumbnail  = $thumbnail;
        $prod->photo  = $photo;
        $prod->update();

        //--- Redirect Section
        return response()->json(['status' => true, 'data' => new ProductDetailsResource($prod), 'error' => []]);
        //--- Redirect Section Ends
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }

    }

    //*** POST Request CATALOG
    public function catalogupdate(Request $request, $id)
    {
      try{
        $user = auth()->user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();
        $old_prod = Product::find($id);

        if($prods < $package->allowed_products || $package->allowed_products == 0)
        {
        //--- Validation Section
        $rules = [
          'name'         => 'required',
          'price'        => 'required',
          'file'         => 'mimes:zip',
          'photo'        => 'mimes:jpeg,jpg,png,svg',
          'type'         => [
                           'required',
                           Rule::in(['Physical', 'Digital', 'License']),
                            ],
          'product_type' => [
                           'required',
                           Rule::in(['normal', 'affiliate']),
                            ],
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }
        //--- Validation Section Ends

        //--- Logic Section
            $data = new Product;
            $sign = Currency::where('is_default','=',1)->first();
            $input = $request->all();
            // Check File

            if ($file = $request->file('file'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/files',$name);
                $input['file'] = $name;
            }

            $image_name = '';
            if($request->is_photo == 1)
            {
                if ($file = $request->file('photo')) 
                {      
                   $name = time().str_replace(' ', '', $file->getClientOriginalName());
                   $file->move('assets/images/products',$name);           
                   $image_name = $name;
                } 
            }
            else {
             $image_name = $old_prod->photo;
            }

            $input['photo'] = $image_name;

            // Check Physical
            if($request->type == "Physical")
            {

            //--- Validation Section
            $rules = ['sku'      => 'min:8|unique:products'];

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
              return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }
            //--- Validation Section Ends

            // Check Condition
            if ($request->product_condition_check == ""){
                $input['product_condition'] = 0;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            // Check Size
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;

            }
            else{
                    if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                    {                  
                        $input['size'] = null;
                        $input['size_qty'] = null;
                        $input['size_price'] = null;
                    }
                    else
                    {
                        $input['size'] = implode(',', $request->size);
                        $input['size_qty'] = implode(',', $request->size_qty);
                        $input['size_price'] = implode(',', $request->size_price);
                    }
            }

            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            // Check Color
            if(empty($request->color_check))
            {
                $input['color'] = null;
            }
            else{
                $input['color'] = implode(',', $request->color);
            }

            // Check Measurement
            if ($request->mesasure_check == "")
             {
                $input['measure'] = null;
             }

            }

            // Check Seo
            if (empty($request->seo_check))
            {
                $input['meta_tag'] = null;
                $input['meta_description'] = null;
            }
            else {
              if (!empty($request->meta_tag))
              {
                  $input['meta_tag'] = implode(',', $request->meta_tag);
              }
            }

             // Check License

            if($request->type == "License")
            {
                if(in_array(null, $request->license) || in_array(null, $request->license_qty))
                {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                }
                else
                {
                    $input['license'] = implode(',,', $request->license);
                    $input['license_qty'] = implode(',', $request->license_qty);
                }
            }

            // Check Features
            if($request->features){
              if(in_array(null, $request->features) || in_array(null, $request->colors))
              {
                  $input['features'] = null;
                  $input['colors'] = null;
              }
              else
              {
                  $input['features'] = implode(',', str_replace(',',' ',$request->features));
                  $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
              }
            }

            //tags
            if (!empty($request->tags))
            {
                $input['tags'] = implode(',', $request->tags);
            }

            // Convert Price According to Currency

            if($request->price){
              $input['price'] = ($input['price'] / $sign->value);
             }
    
             if($request->previous_price){
              $input['previous_price'] = ($input['previous_price'] / $sign->value);
             }

             $input['user_id'] = $user->id;

             // store filtering attributes for physical product
             $attrArr = [];
             if (!empty($request->category_id)) {
               $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
               if (!empty($catAttrs)) {
                 foreach ($catAttrs as $key => $catAttr) {
                   $in_name = $catAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($catAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }

             if (!empty($request->subcategory_id)) {
               $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
               if (!empty($subAttrs)) {
                 foreach ($subAttrs as $key => $subAttr) {
                   $in_name = $subAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($subAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }

             if (!empty($request->childcategory_id)) {
               $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
               if (!empty($childAttrs)) {
                 foreach ($childAttrs as $key => $childAttr) {
                   $in_name = $childAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($childAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }

             if (empty($attrArr)) {
               $input['attributes'] = NULL;
             } else {
               $jsonAttr = json_encode($attrArr);
               $input['attributes'] = $jsonAttr;
             }

            // Save Data

              $data->fill($input)->save();


            // Set SLug

                $prod = Product::find($data->id);
                if($prod->type != 'Physical'){
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower(str_random(3).$data->id.str_random(3));
                }
                else {
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
                }
                $photo = $prod->photo;

                // Set Photo
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(800, null, function ($c) {
                    $c->aspectRatio();
                });
                $photo = time().str_random(8).'.jpg';
                $resizedImage->save(public_path().'/assets/images/products/'.$photo);
                
                // Set Thumbnail

                 $background = Image::canvas(300, 300);
                 $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(300, 300, function ($c) {
                     $c->aspectRatio();
                     $c->upsize();
                 });
                 // insert resized image centered into background
                 $background->insert($resizedImage, 'center');
                 // save or do whatever you like
                 $thumbnail = time().str_random(8).'.jpg';
                 $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);

                $prod->thumbnail  = $thumbnail;
                $prod->photo  = $photo;
                $prod->update();

        //logic Section Ends

        //--- Redirect Section
        return response()->json(['status' => true, 'data' => new ProductDetailsResource($prod), 'error' => []]);
        //--- Redirect Section Ends
        }
        else
        {
        //--- Redirect Section
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'You Can\'t Add More Product.']]);
        //--- Redirect Section Ends
        }
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }


    //*** GET Request
    public function destroy($id)
    {
      try{
      $user = auth()->user();
      $data = Product::find($id);
      if(!$data){
        return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This item does not exist.']]);
      }
      if($data->user_id == $user->id){

        if($data->galleries->count() > 0)
        {
            foreach ($data->galleries as $gal) {
                    if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                    }
                $gal->delete();
            }
        }

        if($data->ratings->count() > 0)
        {
            foreach ($data->ratings  as $gal) {
                $gal->delete();
            }
        }

        if($data->wishlists->count() > 0)
        {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }

        if($data->clicks->count() > 0)
        {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }

        if($data->comments->count() > 0)
        {
            foreach ($data->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }

        if (!filter_var($data->photo,FILTER_VALIDATE_URL)){
            if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                unlink(public_path().'/assets/images/products/'.$data->photo);
            }
        }

        if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
        }

        if($data->file != null){
            if (file_exists(public_path().'/assets/files/'.$data->file)) {
                unlink(public_path().'/assets/files/'.$data->file);
            }
        }

        $data->delete();
        //--- Redirect Section
        return response()->json(['status' => true, 'data' => ['message' => 'Product Deleted Successfully.'], 'error' => []]);
        //--- Redirect Section Ends

      }else{
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'This item is not your.']]);
      }
    }
    catch(\Exception $e){
      return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
    }
    }


    public function getAttributes(Request $request) {
    try{
      $model = '';
      if ($request->type == 'category') {
        $model = 'App\Models\Category';
      } elseif ($request->type == 'subcategory') {
        $model = 'App\Models\Subcategory';
      } elseif ($request->type == 'childcategory') {
        $model = 'App\Models\Childcategory';
      }

      $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
      $attrOptions = [];
      foreach ($attributes as $key => $attribute) {
        $options = AttributeOption::where('attribute_id', $attribute->id)->get();
        $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
      }
      return response()->json(['status' => true, 'data' => $attrOptions, 'error' => []]);
    
    }
    catch(\Exception $e){
      return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
    }
      
      
    }


}