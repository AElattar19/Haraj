<?php

// 	'LOWERCASE_NUMBERS_DASHES' => '/([^\p{Arabic}\u0660-\u0669-a-zA-Z0-9]+|-+)/u',

use App\Support\Actions\HelperClass;

return [

    'source' => null,

    'maxLength' => null,

    'maxLengthKeepWords' => true,

    'method' => [HelperClass::class, 'customSlugMethod'],

    'separator' => '-',

    'unique' => true,

    'uniqueSuffix' => null,

    'includeTrashed' => true,

    'reserved' => null,

    'onUpdate' => false,

];
