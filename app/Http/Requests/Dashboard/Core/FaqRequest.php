<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'question'                           => 'array',
            'question.*'                         => 'nullable|string|max:200|min:2',
            'question.'.get_current_lang()       => 'string|max:100|min:2',
            'answer'                           => 'array',
            'answer.*'                         => 'nullable|string|max:200|min:2',
            'answer.'.get_current_lang()       => 'string|max:100|min:2',
        ];
    }
}
