<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'image' => $this->getImageAttribute()? : $this->getAvatarAttribute(),
            'phone' => $this->phone,
            'fcm_token' => $this->fcm_token,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
