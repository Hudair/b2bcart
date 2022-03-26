<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationMessageResource extends JsonResource
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
            'conversation_subject' => $this->conversation->subject,
            'sent_user' => $this->sent ? $this->sent->name : null,
            'sent_user_id' => $this->sent ? $this->sent->id : null,
            'sent_user_image' => $this->sent ? asset('assets/images/users/'.$this->sent->photo) : null,
            'recieved_user' => $this->recieved ? $this->recieved->name : null,
            'message' => $this->message,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
          ];
    }
}
