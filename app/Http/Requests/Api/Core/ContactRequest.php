<?php

namespace App\Http\Requests\Api\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'email'    => 'required|email',
            'message'  => 'required',
            'phone' => 'nullable|numeric',
            'name'  => 'required',
        ];
    }
}
