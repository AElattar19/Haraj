<?php

namespace App\Http\Requests\Api\Post;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    use ValidationRequest;


    public function rules(): array
    {
        $rules = [
            'price' => 'nullable|numeric|min:1|max:9999999999',
            'title' => 'required|string|min:2|max:200',
            'description' => 'required|string|min:3',
            'images_collection' => 'array',
            'images_collection.*' => 'image',
            'hide_number' => 'required',
            'category_id' => 'required|exists:categories,id',
            'area_id' => 'required|exists:areas,id',
            'phone' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'status' => 'required',
        ];
        return $rules;
    }


}
