<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Validator;

class CouponController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Coupon::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('type', function(Coupon $data) {
                                $type = $data->type == 0 ? "Discount By Percentage" : "Discount By Amount";
                                return $type;
                            })
                            ->editColumn('price', function(Coupon $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = $data->type == 0 ? $data->price.'%' : $sign->sign.round($data->price * $sign->value,2);
                                return $price;
                            })
                            ->addColumn('status', function(Coupon $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            }) 
                            ->addColumn('action', function(Coupon $data) {
                                return '<div class="action-list"><a href="' . route('admin-coupon-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-coupon-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.coupon.index');
    }

    //*** GET Request
    public function create()
    {
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.coupon.create',compact('sign'));
    }

    //*** POST Request
    public function store(Request $request)
    {
       
        //--- Validation Section
        $rules = ['code' => 'unique:coupons','price' => 'required|numeric'];
        $customs = ['code.unique' => 'This code has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }   
        //--- Validation Section Ends
        $sign = Currency::where('is_default','=',1)->first();
        //--- Logic Section
        $data = new Coupon();
        $input = $request->all();
        if($request->type == 1){
            $input['price'] = $request->price * $sign->value;
        }
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.'.'<a href="'.route("admin-coupon-index").'">View Coupon Lists</a>';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    //*** GET Request
    public function edit($id)
    {
        $sign = Currency::where('is_default','=',1)->first();
        $data = Coupon::findOrFail($id);
        return view('admin.coupon.edit',compact('data','sign'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
       
        //--- Validation Section
        $sign = Currency::where('is_default','=',1)->first();
        $rules = ['code' => 'unique:coupons,code,'.$id,
        'price' => 'required|numeric'];
        $customs = ['code.unique' => 'This code has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }        
        //--- Validation Section Ends

        //--- Logic Section
        $data = Coupon::findOrFail($id);
        $input = $request->all();
        if($request->type == 1){
            $input['price'] = $request->price * $sign->value;
        }
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.'.'<a href="'.route("admin-coupon-index").'">View Coupon Lists</a>';
        return response()->json($msg);    
        //--- Redirect Section Ends           
    }
      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Coupon::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }
}
