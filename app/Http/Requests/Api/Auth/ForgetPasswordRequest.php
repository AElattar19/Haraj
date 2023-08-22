<?php

namespace App\Http\Requests\Api\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'phone' => 'required|exists:users,phone|min:9',
        ];
    }
}
