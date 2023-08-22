<?php

namespace App\Http\Requests\Api\Auth;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [

            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'newPasswordConfirmation' => 'required|min:6|same:newPassword',
        ];
    }
}
