<?php

namespace App\Http\Requests\Dashboard\Core;

use App\Support\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        return [
            'title'                           => 'array',
            'title.*'                         => 'nullable|string|max:100|min:2',
            'title.'.get_current_lang()       => 'string|max:100|min:2',
            'description'                     => 'array',
            'description.*'                   => 'nullable|string|max:255|min:2',
            'active'                          => 'nullable|boolean',
            'parent_id'                       => 'nullable|exists:areas,id',
            'level'                           => 'nullable|integer',
            'latitude'                        => 'numeric',
            'longitude'                       => 'numeric',
            'address'                         => 'nullable|string|max:255|min:2',
            'flag'                            => 'nullable|image|mimes:png,jpeg,gif|max:5000',
        ];
    }
}
