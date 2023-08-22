<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (auth()->user() && in_array($this->id, auth()->user()->favourites->pluck('id')->toArray())){
            $favourite = true;
        }else {
            $favourite = false;
        }

        return [
            'id' => $this->id,
            'image' => $this->getMedia('images')->pluck('original_url'),
            'title' => $this->title,
            'description' => $this->description,
            'show_number' => $this->hide_number == 'true'? 'false' : 'true',
            'phone' => $this->phone,
            'area' => $this->area->parent_id == null? $this->area->title : $this->area->MainParent?->title,
            'user' => $this->user?->name,
            'price' => $this->price.' '.t_('sr'),
            'time' => $this->created_at->diffForHumans(),
            'in_favourites' => $favourite,
            'status' => $this->status,
            'user_detail' => UserResource::make($this->user),
        ];
    }
}
