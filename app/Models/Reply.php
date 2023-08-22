<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Reply.
 *
 * @mixin \Eloquent
 */
class Reply extends Model
{
    protected $guarded = [];
    public function childReply(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
