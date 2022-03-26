<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
        'attributable_id' => $this->attributable_id,
        'attributable_type' => $this->attributable_type,
        'name' => $this->name,
        'input_name' => $this->input_name,
        'attribute_options' => route('attibute.options', $this->id),
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
      ];
    }
}
