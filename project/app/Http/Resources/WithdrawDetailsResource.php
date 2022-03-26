<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawDetailsResource extends JsonResource
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
            'amount' => $this->amount,
            'method' => $this->method,
            'acc_email' => $this->acc_email,
            'iban' => $this->iban,
            'country' => $this->country,
            'acc_name' => $this->acc_name,
            'address' => $this->address,
            'swift' => $this->swift,
            'fee' => $this->fee,
            'reference' => $this->reference,
            'status' => ucfirst($this->status),
            'created_at' => ['date'=>$this->created_at->format('d-m-Y h:i:sa')],
        'updated_at' => ['date'=>$this->updated_at->format('d-m-Y h:i:sa')],
          ];
    }
}
