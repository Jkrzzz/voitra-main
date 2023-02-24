<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Dev Routes
|--------------------------------------------------------------------------
|
|
*/

Route::prefix('/admin')->group(function () {
    Route::middleware(['auth.admin', 'auth.role.admin'])->group(function () {
        Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    });

    Route::get('/messages-test/{senderId}/{orderId}', 'Admin\MessageController@test');
});
