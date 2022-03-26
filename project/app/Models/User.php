<?php

namespace App\Models;

use Carbon\Carbon;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = ['name', 'photo', 'zip', 'residency', 'city', 'country', 'address', 'phone', 'fax', 'email','password','affilate_code','verification_link','shop_name','owner_name','shop_number','shop_address','reg_number','shop_message','is_vendor','shop_details','shop_image','f_url','g_url','t_url','l_url','f_check','g_check','t_check','l_check','shipping_cost','date','mail_sent','balance'];


    protected $hidden = [
        'password', 'remember_token'
    ];

    public function IsVendor(){
        if ($this->is_vendor == 2) {
           return true;
        }
        return false;
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction','user_id')->orderby('id','desc');
    }    

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Reply');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function socialProviders()
    {
        return $this->hasMany('App\Models\SocialProvider');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Models\Withdraw');
    }

    public function conversations()
    {
        return $this->hasMany('App\Models\AdminUserConversation');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }


    public function deposits()
    {
        return $this->hasMany('App\Models\Deposit','user_id');
    }

    // Multi Vendor

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function senders()
    {
        return $this->hasMany('App\Models\Conversation','sent_user');
    }

    public function recievers()
    {
        return $this->hasMany('App\Models\Conversation','recieved_user');
    }

    public function notivications()
    {
        return $this->hasMany('App\Models\UserNotification','user_id');
    }

    public function subscribes()
    {
        return $this->hasMany('App\Models\UserSubscription');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\FavoriteSeller');
    }

    public function vendororders()
    {
        return $this->hasMany('App\Models\VendorOrder','user_id');
    }

    public function shippings()
    {
        return $this->hasMany('App\Models\Shipping','user_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Models\Package','user_id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report','user_id');
    }

    public function verifies()
    {
        return $this->hasMany('App\Models\Verification','user_id');
    }

    public function wishlistCount()
    {
        return \App\Models\Wishlist::where('user_id','=',$this->id)->with(['product'])->whereHas('product', function($query) {
                    $query->where('status', '=', 1);
                 })->count();
    }

    public function checkVerification()
    {
        return count($this->verifies) > 0 ? 
        (empty($this->verifies()->where('admin_warning','=','0')->orderBy('id','desc')->first()->status) ? false : ($this->verifies()->orderBy('id','desc')->first()->status == 'Pending' ? true : false)) : false;
    }

    public function checkStatus()
    {
        return count($this->verifies) > 0 ? ($this->verifies()->orderBy('id','desc')->first()->status == 'Verified' ? true : false) :false;
    }

    public function checkWarning()
    {
        return count($this->verifies) > 0 ? ( empty( $this->verifies()->where('admin_warning','=','1')->orderBy('id','desc')->first() ) ? false : (empty($this->verifies()->where('admin_warning','=','1')->orderBy('id','desc')->first()->status) ? true : false) ) : false;
    }

    public function displayWarning()
    {
        return $this->verifies()->where('admin_warning','=','1')->orderBy('id','desc')->first()->warning_reason;
    }

    public static function chekValidation(){
        
        $settings = Generalsetting::findOrFail(1);
        $lastchk = "";
        if (file_exists(base_path().'/schedule.data')){
            $lastchk = file_get_contents(base_path().'/schedule.data');
        }
        $today = Carbon::now()->format('Y-m-d');
        if ($lastchk < $today || $lastchk == ""){
            $newday = strtotime($today);
        
            foreach (DB::table('users')->where('is_vendor','=',2)->get() as  $user) {
                $lastday = $user->date;
                $secs = strtotime($lastday)-$newday;
                $days = $secs / 86400;
                if($days <= 5)
                {
                  if($user->mail_sent == 1)
                  {
                    if($settings->is_smtp == 1)
                    {
                        $data = [
                            'to' => $user->email,
                            'type' => "subscription_warning",
                            'cname' => $user->name,
                            'oamount' => "",
                            'aname' => "",
                            'aemail' => "",
                            'onumber' => ""
                        ];
                        $mailer = new GeniusMailer();
                        $mailer->sendAutoMail($data);
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Your subscription plan duration will end after five days. Please renew your plan otherwise all of your products will be deactivated.Thank You.',$headers);
                    }
                    DB::table('users')->where('id',$user->id)->update(['mail_sent' => 0]);
                  }
                }
                if($today > $lastday)
                {
                    DB::table('users')->where('id',$user->id)->update(['is_vendor' => 1]);
                }
            }

            $handle = fopen(base_path().'/schedule.data','w+');
            fwrite($handle,$today);
            fclose($handle);

        }
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}