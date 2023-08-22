<?php

route_group('maincategory', function () {

    Route::resources([
        'maincategories' => 'MainCategoryController',
    ]);
});
