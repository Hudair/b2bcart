<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'details'           => strip_tags($this->details),
            'photo'             => url('/') . '/assets/images/blogs/'.$this->photo,
            'source'            => $this->source,
            'views'             => $this->views,
            'status'            => $this->status,
            'meta_tag'          => $this->meta_tag,
            'meta_description'  => $this->meta_description,
            'tags'              => $this->source,
            'created_at' => ['date'=>$this->created_at->format('d-m-Y h:i:sa')],
        
          ];
    }
}
