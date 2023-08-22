<?php

namespace App\Http\Requests\Frontend\Auth\Reset;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhoneRequest extends FormRequest
{
    use ValidationRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone_number.full' => [
                'required',
                'phone:AUTO,SA',
                Rule::exists('users', 'phone'),
            ],
        ];
    }
}
