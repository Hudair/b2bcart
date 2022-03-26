<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
        'product_id' => $this->product_id,
        'title' => $this->title,
        'note' => $this->note,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
      ];
    }
}
