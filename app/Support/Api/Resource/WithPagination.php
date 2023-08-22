<?php

namespace App\Support\Api\Resource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait WithPagination
{
    public static function collection($resource)
    {
        return tap(new AnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        })->response()
          ->getData(true);
    }
}
