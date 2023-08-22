<?php

route_group('user', function () {

    Route::resources([
        'users' => 'UserController',
    ]);
});
