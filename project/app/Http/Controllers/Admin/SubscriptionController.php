<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Subscription::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('price', function(Subscription $data) {
                                $currency = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $currency->value,2);
                                return $price;
                            })
                            ->addColumn('currency',function(Subscription $data){
                                $currency = Currency::where('is_default','=',1)->first();
                                return $currency->name;
                            })
                            ->editColumn('allowed_products', function(Subscription $data) {
                                $allowed_products = $data->allowed_products == 0 ? "Unlimited": $data->allowed_products;
                                return $allowed_products;
                            })
                            ->addColumn('action', function(Subscription $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-subscription-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-subscription-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['currency','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.subscription.index');
    }

    //*** GET Request
    public function create()
    {
        $data['currency'] = Currency::where('is_default','=',1)->first();
        return view('admin.subscription.create',$data);
    }

    //*** POST Request
    public function store(Request $request)
    {
         //--- Validation Section
         $rules = [
            'price'      => 'required|numeric',
             ];

     $validator = Validator::make($request->all(), $rules);
     
     if ($validator->fails()) {
       return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
     }
     //--- Validation Section Ends


        //--- Logic Section
        $data = new Subscription();
        $input = $request->all();

        if($input['limit'] == 0)
         {
            $input['allowed_products'] = 0;
         }

         $currency = Currency::where('is_default','=',1)->first();
         $sign = $currency->sign;
         $name = $currency->name;

         $input['currency'] = $sign;
         $input['currency_code'] = $name;

         if($request->price){
            $input['price'] = ($request->price / $currency->value);
         }



        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Subscription::findOrFail($id);
        $currency = Currency::where('is_default','=',1)->first();
        return view('admin.subscription.edit',compact('data','currency'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

            //--- Validation Section
            $rules = [
                'price'      => 'required|numeric',
                 ];
    
         $validator = Validator::make($request->all(), $rules);
         
         if ($validator->fails()) {
           return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
         }
         //--- Validation Section Ends
    

        //--- Logic Section
        $data = Subscription::findOrFail($id);
        $input = $request->all();
        if($input['limit'] == 0)
         {
            $input['allowed_products'] = 0;
         }

         $currency = Currency::where('is_default','=',1)->first();
         $sign = $currency->sign;
         $name = $currency->name;

         $input['currency'] = $sign;
         $input['currency_code'] = $name;

         if($request->price){
            $input['price'] = ($request->price / $currency->value);
         }

        $data->update($input);
        //--- Logic Section Ends
        $data->subs()->update(['allowed_products' => $data->allowed_products]);


        //--- Redirect Section     
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Subscription::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}