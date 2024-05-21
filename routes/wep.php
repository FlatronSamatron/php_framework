<?php

use Framework\Routing\Route;

return [
        Route::get('/', ['HomeController::class', 'index'])
];