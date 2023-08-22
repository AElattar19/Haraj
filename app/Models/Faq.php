<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\SlugModel;
use App\Support\Traits\WithBoot;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Faq.
 *
 * @mixin \Eloquent
 */
class Faq extends Model
{
    use HasTranslations;

    protected array $translatable = ['question', 'answer'];

    protected $guarded = [];

}
