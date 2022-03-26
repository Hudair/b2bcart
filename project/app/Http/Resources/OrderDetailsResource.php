<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
         
       $cart = json_decode($this->cart,true);
       
       

      foreach($cart['items'] as $item){
         $new_cart[] = $item;
      }
      $i = 0;
      foreach($new_cart as $value){

           
            $newdata["id"] = $new_cart[$i]['item']['id'];
            $newdata['name'] = $new_cart[$i]['item']['name'];
            $newdata['vendor_id'] = $new_cart[$i]['item']['user_id'];
            $newdata['type'] = $new_cart[$i]['item']['type'];
            $newdata['feature_image'] = url('/') . '/assets/images/products/'.$new_cart[$i]['item']['photo'];
            
            $new_cart[$i] += $newdata;
            unset($new_cart[$i]['item']);

          
          $new_cart[$i] += ['total_price' => $new_cart[$i]['price']];

          unset($new_cart[$i]['license']);
          unset($new_cart[$i]['dp']);
          unset($new_cart[$i]['price']);
        $i++;
         
      }
        
        
        
        
      return [
        'id' => $this->id,
        'number' => $this->order_number,
        'total' => $this->currency_sign . "" . round($this->pay_amount * $this->currency_value , 2),
        'status' => $this->status,
        'payment_status' => $this->payment_status,
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
        'paid_amount' => $this->currency_sign . '' . round($this->pay_amount * $this->currency_value , 2),
        'payment_method' => $this->method,
        'shipping_cost' => $this->shipping_cost,
        'packing_cost' => $this->packing_cost,
        'charge_id' => $this->charge_id,
        'transaction_id' => $this->txnid,
        'ordered_products' => $new_cart,
        // 'ordered_products' => $this->when(!empty($this->cart), function() {
        //   $cart = unserialize(bzdecompress(utf8_decode($this->cart)));
        //   foreach($cart->items as $item){
        //         $new_cart[] = $item;
        //     }
        //   return $new_cart;
        // }),
        'created_at' => ['date'=>$this->created_at->format('d-m-Y h:i:sa')],
        'updated_at' => ['date'=>$this->updated_at->format('d-m-Y h:i:sa')],
      ];
    }
}
