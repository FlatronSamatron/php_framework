<?php

use App\Controllers\{HomeController, PostController};
use Framework\Routing\Route;

return [
        Route::get('/', [HomeController::class, 'index']),
        Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
];