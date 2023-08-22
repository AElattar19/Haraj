<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\FeatureOption.
 *
 * @mixin \Eloquent
 */
class FeatureOption extends Model
{
    use SlugModel,WithBoot;

    protected $guarded = [];

}
