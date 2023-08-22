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

class Category extends Model implements HasMedia

{
    use WithBoot, SlugModel, HasTranslations, InteractsWithMedia;

    protected array $translatable = ['title'];

    protected $guarded = [];

    private $allSubs = [];
    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }
    public function categories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function findDescendants($category){
        $this->allSubs[] = $category->id;

        if($category->categories->count()){
            foreach($category->categories as $child){
                $this->findDescendants($child);
            }
        }
    }
    public function getDescendants($category){
        $this->findDescendants($category);
        return $this->allSubs;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getParentsAttribute(): Collection
    {
        $parents = collect([]);
        $parent = $this->parent;

        while(!is_null($parent)) {
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
