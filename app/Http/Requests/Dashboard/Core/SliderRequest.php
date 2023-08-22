<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'title'          => 'array',
            'title.*'        => 'required|string|min:2|max:200',
            'description'    => 'array',
            'description.*'  => 'required|string|min:2|max:200',
            'image'          => 'required|image',
        ];
    }
}
