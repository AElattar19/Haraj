<?php

namespace App\Http\Requests\Dashboard\Post;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    use ValidationRequest;


    public function rules(): array
    {
        $rules = [
            'price' => 'required|numeric|min:1|max:9999999999',
            'title' => 'required|string|min:2|max:200',
            'description' => 'required|string|min:3',
            'images_collection' => 'array',
            'images_collection.*' => 'string|max:200|min:1',
            'user_id' => 'required|exists:users,id',
            'cat_id' => 'array',
            'cat_id.*' => 'required|exists:categories,id',
            'area_id' => 'array',
            'area_id.*' => 'required|exists:areas,id',
            'phone' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ];
        return $rules;
    }


}
