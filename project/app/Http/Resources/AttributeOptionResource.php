<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeOptionResource extends JsonResource
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
        'attribute_id' => $this->attribute_id,
        'name' => $this->name,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
      ];
    }
}
