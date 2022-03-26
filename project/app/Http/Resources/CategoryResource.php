<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductlistResource;

class CategoryResource extends JsonResource
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
        'name' => $this->name,
        'icon' => url('/') . '/assets/images/categories/'.$this->photo,
        'image' => $this->when($this->image, url('/') . '/assets/images/categories/'.$this->image),
        'count' => $this->products()->where('status', 1)->count() . ' item(s)',
        'products' => ProductlistResource::collection($this->products()->where('status', 1)->get()),
        'subcategories' => route('subcategories', $this->id),
        'attributes' => route('attibutes', $this->id) . '?type=category',
      ];
    }
}
