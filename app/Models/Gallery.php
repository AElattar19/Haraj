<?php

namespace App\Models;

use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Gallery.
 *
 * @mixin \Eloquent
 */
class Gallery extends Model implements HasMedia

{
    use WithBoot, HasTranslations, InteractsWithMedia;

    protected $translatable = ['title', 'description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
    ];
    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }

}
