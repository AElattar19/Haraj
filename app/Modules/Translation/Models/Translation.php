<?php

namespace Modules\Translation\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $guarded = [];

    protected $table = 'translations';

    protected $casts = ['t_' => 'array'];
}
