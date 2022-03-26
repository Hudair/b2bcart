<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorOrderResource extends JsonResource
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
            'total_qty' => $this->vendororders()->where('user_id','=',$user->id)->sum('qty'),
            'pay_amount' => $this->currency_sign . "" . round($this->vendororders()->where('user_id','=',$user->id)->sum('price') * $this->currency_value , 2),
            'status' => $this->status,
            'details' => route('vorder-show', $this->order_number),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          ];
    }
}
