<?php

route_group('ticket', function () {

    Route::resources([
        'departments' => 'DepartmentController',
        
     ]);
});
