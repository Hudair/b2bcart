<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
        'title' => $this->title,
        'slug' => $this->slug,
        'content' => strip_tags($this->details),
        'meta_tag' => $this->meta_tag,
        'meta_description' => $this->meta_description,
        'header' => $this->header,
        'footer' => $this->footer,
      ];
    }
}
