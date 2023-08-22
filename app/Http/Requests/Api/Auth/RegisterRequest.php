<?php

namespace App\Http\Requests\Api\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [

            'email'    => 'required|unique:users',
            'password' => 'required|min:6',
            'name'     => 'required',
            'phone'    => 'required|unique:users',
            'fcm_token' => 'nullable|string|max:1000',
        ];
    }
}
