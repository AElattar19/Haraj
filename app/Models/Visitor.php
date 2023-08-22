<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Visitor.
 *
 * * @mixin \Eloquent
 */
class Visitor extends Model
{
    public $guarded = [];

    protected $casts = [
        'data'       => 'array',
        'created_at' => 'datetime:Y-m-d h:m > A ',
    ];

    public const  AddToPermission = true;

    // Customize log name
    protected static $logName = 'Visitor';

    // Only defined attribute will store in log while any change
    protected static $logAttributes = ['title', 'description', 'active'];

    // Customize log description
    public function getDescriptionForEvent(string $eventName): string
    {
        return t_('has been {:name}', ['name'=>$eventName]);
    }
}
