<?php

namespace App\Http\Requests\Frontend\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'name'     => 'required|min:2|max:191',
            'image'    => 'image',
            'email'    => 'required|email:rfc,dns|unique:users,email',
            'phone'    => 'required|min:4|max:30|phone:AUTO',
            'password' => [
                'required', 'string', 'confirmed',
                // Password::min(6)->mixedCase() ->numbers() ->symbols() ->uncompromised(),
            ],
        ];
    }
}
