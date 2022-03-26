<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductlistResource extends JsonResource
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
        'title' => $this->name,
        'thumbnail' => url('/') . '/assets/images/thumbnails/'.$this->thumbnail,
        'rating' => $this->ratings()->avg('rating') > 0 ? round($this->ratings()->avg('rating'), 2) : round(0.00, 2),
        'current_price' =>  $this->vendorSizePrice(),
        'previous_price' => $this->vendorSizePrice(),
        'sale_end_date' => $this->when($this->is_discount == 1, $this->discount_date),
        'created_at' => ['date'=>$this->created_at->format('d-m-Y h:i:sa')],
        'updated_at' => ['date'=>$this->updated_at->format('d-m-Y h:i:sa')],
      ];
    }
}
