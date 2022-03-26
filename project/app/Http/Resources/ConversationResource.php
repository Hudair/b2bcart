<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'subject' => $this->subject,
            'sent_user' => $this->sent ? $this->sent->name : null,
            'recieved_user' => $this->recieved ? $this->recieved->name : null,
            'message' => $this->message,
            'messages' => ConversationMessageResource::collection($this->messages),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
          ];
    }
}
