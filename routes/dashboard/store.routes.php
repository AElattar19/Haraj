<?php

route_group('store', function () {

    Route::resources([
        'stores'     => 'StoreController',
        'products'   => 'ProductController',
        'additions'  => 'AdditionController',
        'categories' => 'CategoryController',
        'orders'     => 'OrderController',

    ]);
    Route::get('product/store', 'ProductController@getStoreDetails')->name('store.details');

});
