<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Subscription extends Model
{
    protected $fillable = ['title','currency','currency_code','price','days','allowed_products','details'];

    public $timestamps = false;

    public function subs()
    {
        return $this->hasMany('App\Models\UserSubscription','subscription_id');
    }

    public function convertedPrice($price){
        $gs = Generalsetting::findOrFail(1);
        
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $price = round($price * $curr->value,2);
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
    }

    public function convertedUserPrice($price){
        $gs = Generalsetting::findOrFail(1);
        
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $price = round($price * $curr->value,2);
        return $price;
    }

}