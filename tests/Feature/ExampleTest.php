<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the landing page renders for guests', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertViewIs('landing');
    $response->assertSee('Scholar');
    $response->assertSee('Elevating Academic');
});

test('the landing page renders for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertOk();
    $response->assertViewIs('landing');
});
