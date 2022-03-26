<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorOrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();
        return [
            'id' => $this->id,
            'number' => $this->order_number,
            'status' => $this->status,
            'shipping_name' => empty($this->shipping_name) ? $this->customer_name : $this->shipping_name,
            'shipping_email' => empty($this->shipping_email) ? $this->customer_email : $this->shipping_email,
            'shipping_phone' => empty($this->shipping_phone) ? $this->customer_phone : $this->shipping_phone,
            'shipping_address' => empty($this->shipping_address) ? $this->customer_address : $this->shipping_address,
            'shipping_zip' => empty($this->shipping_zip) ? $this->customer_zip : $this->shipping_zip,
            'shipping_city' => empty($this->shipping_city) ? $this->customer_city : $this->shipping_city,
            'shipping_country' => empty($this->shipping_country) ? $this->customer_country : $this->shipping_country,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'customer_zip' => $this->customer_zip,
            'customer_city' => $this->customer_city,
            'customer_country' => $this->customer_country,
            'shipping' => $this->shipping,
            'total_qty' => $this->vendororders()->where('user_id','=',$user->id)->sum('qty'),
            'pay_amount' => $this->currency_sign . "" . round($this->vendororders()->where('user_id','=',$user->id)->sum('price') * $this->currency_value , 2),
            'shipping_cost' => $this->when($this->vendor_shipping_id == $user->id, function() {
                return $this->shipping_cost;
            }),
            'packing_cost' => $this->when($this->vendor_packing_id == $user->id, function() {
                return $this->packing_cost;
            }),
            'packing_cost' => $this->packing_cost,
            'ordered_products' => $this->when(!empty($this->cart), function() use ($user) {
            $user = auth()->user();
              $cart = unserialize(bzdecompress(utf8_decode($this->cart)));
              $prods = $cart->items;
              foreach($prods as $key => $data){
                  if($data['item']['user_id'] != $user->id){
                      unset($prods[$key]);
                  }
              }
              return $prods;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          ];
    }
}
