<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence-message-{group}', function ($user, $group) {
    return $user;
});

Broadcast::channel('private-message-{group}', function ($user, $group) {
    return $user;
});

// Broadcast::channel('public-message', function ($user) {
//     return true;
// });
