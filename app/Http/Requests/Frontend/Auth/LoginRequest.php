<?php

namespace App\Http\Requests\Frontend\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
