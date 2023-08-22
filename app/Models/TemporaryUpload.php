<?php

namespace App\Models;

use App\Support\Traits\WithBoot;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Temp.
 *
 * @mixin \Eloquent
 */
class TemporaryUpload extends Model implements HasMedia
{
    use WithBoot, InteractsWithMedia;

    protected $guarded = [];
}
