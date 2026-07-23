<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-reset.{token}', function ($user, $token) {
    return session('reset_channel_token') === $token;
});
