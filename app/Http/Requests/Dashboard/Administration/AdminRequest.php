<?php

namespace App\Http\Requests\Dashboard\Administration;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {

        $rules = [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(4)],
            'avatar'    => 'nullable|image',
            'roles'    => 'nullable|array',
            'active'   => 'nullable',
        ];

        if (request()->isMethod('PUT')) {
            $rules['name'] = 'required|string|max:100';
            $rules['password'] = ['nullable', 'confirmed', Password::min(4)];
            $rules['email'] = 'required|email|max:255|unique:users,id,'.request()->user()->id;
        }

        return $rules;
    }
}
