<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates users via factory', function () {
    User::factory()->count(10)->create();

    $this->assertDatabaseCount('users', 10);
});
