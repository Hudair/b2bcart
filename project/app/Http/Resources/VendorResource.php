<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Generalsetting;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $gs = Generalsetting::first();

        return [
          'id' => $this->id,
          'full_name' => $this->name,
          'phone' => $this->phone,
          'email' => $this->email,
          'fax' => $this->fax,
          'propic' => $this->photo ? url('/') . '/assets/images/users/' . $this->photo : url('/') . '/assets/images/'.$gs->user_image,
          'zip_code' => $this->zip,
          'city' => $this->city,
          'country' => $this->country,
          'address' => $this->address,
          'balance' => $this->current_balance,
          'email_verified' => $this->email_verified,
          'affilate_code' => $this->affilate_code,
          'affilate_income' => $this->affilate_income,
          'shop_name' => $this->shop_name,
          'owner_name' => $this->owner_name,
          'shop_number' => $this->shop_number,
          'shop_address' => $this->shop_address,
          'shop_message' => $this->shop_message,
          'shop_details' => $this->shop_details,
          'shop_image' => $this->shop_image ? url('/') . '/assets/images/vendorbanner/' . $this->shop_image : '#6f1ed6',
          'facebook' => [
            'url' => $this->f_url,
            'visibility' => $this->f_check
          ],
          'google' => [
            'url' => $this->g_url,
            'status' => $this->g_check
          ],
          'twitter' => [
            'url' => $this->t_url,
            'status' => $this->t_check
          ],
          'linkedin' => [
            'url' => $this->l_url,
            'status' => $this->l_check
          ],
          'ban' => $this->ban,
        ];
    }
}
