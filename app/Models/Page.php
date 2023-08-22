<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $timestamps = false;

    protected $fillable = ['body'];

    protected $translatable = ['title', 'body'];

    public const TERMS = 'terms';

    public const ABOUT = 'about';

    public const PRIVACY = 'privacy';

    public const Qsm = 'qasam';

    protected $primaryKey = 'key';

    protected $keyType = 'string';
}
