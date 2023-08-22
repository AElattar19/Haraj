<?php

namespace App\Http\Requests\Frontend\Auth\Reset;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'password' => ['required', 'min:4', 'confirmed'],
        ];
    }
}
