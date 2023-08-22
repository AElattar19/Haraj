<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSetting extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'facebook'              => 'nullable',
            'instagram'             => 'nullable',
            'twitter'               => 'nullable',
            'google_plus'           => 'nullable',
            'site_name'             => 'string|max:100|min:3',
            'site_logo'             => 'image',
            'site_favicon'          => 'image',
            'type'                  => 'required',
            'google_api'            => 'string',
        ];
    }
}
