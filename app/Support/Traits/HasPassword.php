<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Hash;

/**
 * @mixin \Eloquent
 **/
trait HasPassword
{
    public function setPasswordAttribute($value)
    {
        if ($value === null || ! is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
}
