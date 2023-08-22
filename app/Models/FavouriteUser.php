<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\FavouriteUser.
 *
 * @mixin \Eloquent
 */
class FavouriteUser extends Model
{

    protected $guarded = [];

}
