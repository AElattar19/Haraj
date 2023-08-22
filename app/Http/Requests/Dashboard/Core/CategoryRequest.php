<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'title'    => 'array',
            'title.*'  => 'required|string|min:2|max:200',
            'active'   => 'boolean',
            'parent_id'   => 'nullable|exists:categories,id',
            'image'    => 'image',
        ];
    }
}
