<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Feature.
 *
 * @mixin \Eloquent
 */
class Feature extends Model
{
    use SlugModel,WithBoot;

    protected $guarded = [];

}
