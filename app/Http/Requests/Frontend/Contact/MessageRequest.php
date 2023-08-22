<?php

namespace App\Http\Requests\Frontend\Contact;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:191',
            'email' => 'required|email',
            'phone' => 'required|min:4|max:30',
            'subject' => 'required|min:4|max:100',
            'message' => 'required|min:10',
        ];
    }
}
