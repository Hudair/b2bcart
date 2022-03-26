<?php

namespace App\Http\Controllers\Api\Front;

use App\{
    Models\Product,
    Models\Category,
    Models\Attribute,
    Models\Subcategory,
    Models\Childcategory,
    Models\AttributeOption
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\CategoryResource,
    Http\Resources\AttributeResource,
    Http\Resources\ProductlistResource,
    Http\Resources\SubcategoryResource,
    Http\Resources\ChildcategoryResource,
    Http\Resources\AttributeOptionResource
};

use Illuminate\{
    Http\Request,
    Support\Collection
};

use Validator;

class SearchController extends Controller
{

    public function categories() {
      try{
      $cats = Category::where('status','=',1)->get();
      return response()->json(['status' => true, 'data' => CategoryResource::collection($cats), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }


    public function category($id) {
      try{
      $cat = Category::where('status','=',1)->where('id',$id)->get();
      return response()->json(['status' => true, 'data' => CategoryResource::collection($cat), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function subcategories($id) {
      try{
      $subcats = Subcategory::where('category_id',$id)->where('status','=',1)->get();
      return response()->json(['status' => true, 'data' => SubcategoryResource::collection($subcats), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function childcategories($id) {
      try{
      $childcats = Childcategory::where('subcategory_id',$id)->where('status','=',1)->get();
      return response()->json(['status' => true, 'data' => ChildcategoryResource::collection($childcats), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function attributes(Request $request, $id) {
      try{


        $rules = [
          'type' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $type          = $request->type;
        $checkType =  in_array($type, ['category','subcategory','childcategory']);
        if(!$checkType){
          return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "This type doesn't exists."]]);
        }


      if ($type== 'category') {
        $attributes = Attribute::where('attributable_id', $id)->where('attributable_type', 'App\Models\Category')->get();
      }
      if ($type== 'subcategory') {
        $attributes = Attribute::where('attributable_id', $id)->where('attributable_type', 'App\Models\Subcategory')->get();
      }
      if ($type == 'childcategory') {
        $attributes = Attribute::where('attributable_id', $id)->where('attributable_type', 'App\Models\Childcategory')->get();
      }

      return response()->json(['status' => true, 'data' => AttributeResource::collection($attributes), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function attributeoptions($id) {
      try{
      $attributeOpts = AttributeOption::where('attribute_id', $id)->get();
      return response()->json(['status' => true, 'data' => AttributeOptionResource::collection($attributeOpts), 'error' => []]);
      }
      catch(\Exception $e){
        return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
      }
    }

    public function search(Request $request)
    {
      try{
      $minprice = $request->min;
      $maxprice = $request->max;
      $sort = $request->sort;
      $search = $request->term;

        
      if (!empty($request->category)) {
        $cat = Category::find($request->category);
      } else {
        $cat = NULL;
      }
      if (!empty($request->subcategory)) {
        $subcat = Subcategory::find($request->subcategory);
      } else {
        $subcat = NULL;
      }
      if (!empty($request->childcategory)) {
        $childcat = Childcategory::find($request->childcategory);
      } else {
        $childcat = NULL;
      }

      $prods = Product::when($cat, function ($query, $cat) {
                                      return $query->where('category_id', $cat->id);
                                  })
                                  ->when($subcat, function ($query, $subcat) {
                                      return $query->where('subcategory_id', $subcat->id);
                                  })
                                  ->when($childcat, function ($query, $childcat) {
                                      return $query->where('childcategory_id', $childcat->id);
                                  })
                                  ->when($search, function ($query, $search) {
                                      return $query->where('name', 'like', '%' . $search . '%');
                                  })
                                  ->when($minprice, function($query, $minprice) {
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
                                  });
                                  
                           
                                  $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $request) {
                                              $flag = 0;

                                              if (!empty($cat)) {
                                                foreach ($cat->attributes as $key => $attribute) {
                                                  $inname = $attribute->input_name;
                                                  $chFilters = $request["$inname"];
                                                  if (!empty($chFilters)) {
                                                    $flag = 1;
                                                    foreach ($chFilters as $key => $chFilter) {
                                                      if ($key == 0) {
                                                        $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      } else {
                                                        $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      }

                                                    }
                                                  }
                                                }
                                              }

                                              if (!empty($subcat)) {
                                                foreach ($subcat->attributes as $attribute) {
                                                  $inname = $attribute->input_name;
                                                  $chFilters = $request["$inname"];
                                                  if (!empty($chFilters)) {
                                                    $flag = 1;
                                                    foreach ($chFilters as $key => $chFilter) {
                                                      if ($key == 0 && $flag == 0) {
                                                        $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      } else {
                                                        $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      }

                                                    }
                                                  }

                                                }
                                              }

                                              if (!empty($childcat)) {
                                                foreach ($childcat->attributes as $attribute) {
                                                  $inname = $attribute->input_name;
                                                  $chFilters = $request["$inname"];
                                                  if (!empty($chFilters)) {
                                                    $flag = 1;
                                                    foreach ($chFilters as $key => $chFilter) {
                                                      if ($key == 0 && $flag == 0) {
                                                        $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      } else {
                                                        $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
                                                      }

                                                    }
                                                  }

                                                }
                                              }

                                          });

                                  $prods = $prods->where('status', 1)->get();
                                  
                                  $prods = (new Collection(Product::filterProducts($prods)));
                                
                                  return response()->json(['status' => true, 'data' => ProductlistResource::collection($prods->flatten(1)), 'error' => []]);
        }
        catch(\Exception $e){
          return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }

    }
}
