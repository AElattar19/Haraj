<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\PostFeature.
 *
 * @mixin \Eloquent
 */
class PostFeature extends Model
{
    use SlugModel,WithBoot;

    protected $guarded = [];

}
