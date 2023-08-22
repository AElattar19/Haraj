<?php

namespace App\Http\Requests\Api\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'fcm_token' => 'nullable|string|max:1000',
        ];
        if (is_numeric(request()->email)) {
            $rules['email'] = 'required|numeric';
        }
        if (filter_var(request()->email, FILTER_VALIDATE_EMAIL)) {
            $rules['email'] = 'required';
        }
        return $rules;
    }
}
