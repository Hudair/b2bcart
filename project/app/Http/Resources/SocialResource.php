<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
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
        'facebook' => $this->facebook,
        'facebook_status' => $this->f_status,
        'googleplus' => $this->gplus,
        'google_status' => $this->g_status,
        'twitter' => $this->twitter,
        'twitter_status' => $this->t_status,
        'linkedin' => $this->linkedin,
        'linkedin_status' => $this->l_status,
        'dribble' => $this->dribble,
        'dribble_status' => $this->d_status
      ];
    }
}
