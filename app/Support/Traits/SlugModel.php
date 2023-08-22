<?php

namespace App\Support\Traits;

use Cviebrock\EloquentSluggable\Sluggable;

trait SlugModel
{
    use Sluggable;

    public function sluggable(): array
    {

        return [
            'slug' => [
                'source' => 'created_at',
            ],
        ];
    }
}
