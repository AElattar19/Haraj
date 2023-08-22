<?php

namespace Modules\Language\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Language extends Authenticatable
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'languages';

    protected $guarded = [];

    public function scopeActive($query)
    {

        return $query->where('active', true);
    }
}
