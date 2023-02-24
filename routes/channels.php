<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('App.Models.Admin.{id}', function (Admin $admin, $id) {
    return (int) $admin->id === (int) $id;
}, ['guards' => ['admin']]);

// Broadcast::channel('events', function (Admin $user) {
//     // Log::info($user);

//     return true;
// }, ['guards' => ['admin']]);

Broadcast::channel('room.{id}', function (Admin $user, $id) {
    // Log::info($user);

    return true;
}, ['guards' => ['admin']]);
