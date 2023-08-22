<?php

namespace App\Models;

use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\User.
 *
 * @mixin \Eloquent
 */
class Product extends Model implements HasMedia
{
    use SlugModel, HasTranslations, InteractsWithMedia, WithBoot;

    protected $translatable = ['title', 'description'];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function additions()
    {
        return $this->belongsToMany(Addition::class, 'product_additions', 'products_id', 'additions_id');
    }
}
