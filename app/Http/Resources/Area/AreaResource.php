<?php

namespace App\Http\Resources\Area;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'active' => $this->active,
            'image' => $this->getMedia('flag')->pluck('original_url'),
            'children' => AreaResource::collection($this->areas),
            'time' => $this->created_at->diffForHumans(),
        ];
    }
}
