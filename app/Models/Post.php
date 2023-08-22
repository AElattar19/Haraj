<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Post.
 *
 * @mixin \Eloquent
 */
class Post extends Model implements HasMedia
{
use InteractsWithMedia;
    protected $guarded = [];
    protected function getImagesAttribute(): string
    {
        return $this->getMedia('images');
    }
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'post_id')->whereNull('parent_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
