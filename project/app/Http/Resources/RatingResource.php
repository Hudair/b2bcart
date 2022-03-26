<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RatingResource extends JsonResource
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
        'user_image' => empty($this->user->photo) ? url('/') . '/assets/images/noimage.png' : url('/') . '/assets/images/users/' . $this->user->photo,
        'user_id' => $this->user_id,
        'name' => $this->user->name,
        'review' => $this->review,
        'rating' => $this->rating,
        'review_date' => Carbon::createFromFormat('Y-m-d H:i:s',$this->review_date)->diffForHumans(),
      ];
    }
}
