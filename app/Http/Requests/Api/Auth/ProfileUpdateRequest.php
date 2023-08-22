<?php

namespace App\Http\Requests\Api\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users,id,'.auth()->user()->id,
            'phone'    => 'required|min:9',
            'image'    => ''
        ];
    }
}
