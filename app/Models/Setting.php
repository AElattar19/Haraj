<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting.
 *
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];
}
