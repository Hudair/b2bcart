<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositListResource extends JsonResource
{
    
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
      return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'deposit_number' => $this->deposit_number,
        'currency_code' => $this->currency_code,
        'amount' => 5,
        'currency_value' => $this->currency_value,
        'method' => $this->method,
        'txnid' => $this->txnid,
        'flutter_id' => $this->flutter_id,
        'status' => $this->status,
         'created_at' => $this->created_at->format('d-m-Y h:i:s'),
        'updated_at' => $this->updated_at->format('d-m-Y h:i:s'),
      ];
    }
}
