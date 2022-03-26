<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
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
        'comment' => $this->text,
        'created_at' => $this->created_at->diffForHumans(),
        'updated_at' => $this->updated_at->diffForHumans(),
      ];
    }
}
