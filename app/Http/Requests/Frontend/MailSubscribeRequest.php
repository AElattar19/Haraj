<?php

namespace App\Http\Requests\Frontend;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class MailSubscribeRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'subscribed_email' => 'required|email|unique:news_later,email',
        ];
    }
}
