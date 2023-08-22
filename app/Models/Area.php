<?php

namespace App\Models;

use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;


class Area extends Model implements HasMedia
{
    use WithBoot, SlugModel, InteractsWithMedia, HasTranslations;

    protected array $translatable = ['title', 'description'];

    protected $guarded = [];
    protected $with = ['media'];

    public function getFlagAttribute(): string
    {
        return $this->getFirstMediaUrl('flag');
    }

    public function sluggable(): array
    {

        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'area_id');
    }
    public function areas(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getParentsAttribute(): Collection
    {
        $parents = collect([]);
        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function getMainParentAttribute()
    {
        return $this->Parents->whereNull('parent_id')->first();
    }
}
