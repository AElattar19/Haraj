<?php

namespace App\Support\Traits;

trait WithBoot
{
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
