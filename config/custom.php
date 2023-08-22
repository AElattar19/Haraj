<?php

// custom.php file returd default configuration setting of layouts
return [
    'FORCE_HTTPS'            => env('APP_HTTPS', false),
    'dashboard'              => [
        'prefix' => 'admin',
    ],
    'APP_HZ_TRANSLATION'     => env('APP_HZ_TRANSLATION', false),
    'YANDEX_TRANSLATION_API' => env('YANDEX_TRANSLATION_API', false),
    'GOOGLE_MAP_API' => env('GOOGLE_MAP_API'),
];
