<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductlistResource;

class ChildcategoryResource extends JsonResource
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
        'subcategory_id' => $this->subcategory_id,
        'name' => $this->name,
        'attributes' => route('attibutes', $this->id) . '?type=childcategory',
        'products' => ProductlistResource::collection($this->products()->where('status', 1)->get()),
        'created_at' => ['date'=>$this->created_at->format('d.m.Y')],
        'updated_at' => ['date'=>$this->updated_at->format('d.m.Y')],
      ];
    }
}
