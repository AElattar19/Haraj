<?php

route_group('homesection', function () {

    Route::resources([
        'homesections' => 'HomeController',
    ]);
});
