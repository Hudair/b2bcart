<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTrackResource extends JsonResource
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
        'order_id' => $this->user_id,
        'title' => $this->title,
        'text' => $this->text,
        'created_at' => $this->created_at->diffForHumans(),
        'updated_at' => $this->updated_at->diffForHumans(),
      ];
    }
}
