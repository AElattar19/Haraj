<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\contactUs.
 *
 * @mixin \Eloquent
 */
class ContactUs extends Model
{
    protected $guarded = [];
    protected static function boot()
    {

        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth(activeGuard())->id();
        });

        static::updating(function ($query) {
            $query->updated_by = auth(activeGuard())->id();
        });
    }
}
