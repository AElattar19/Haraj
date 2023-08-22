<?php

namespace App\Http\Requests\Frontend\Profile;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'name'  => 'required|between:2,191',
            'image' => 'nullable|image',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'phone' => 'required|phone:AUTO',
        ];
    }
}
