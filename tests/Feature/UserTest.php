<?php

use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\{actingAs, artisan, post, assertDatabaseHas};

uses(RefreshDatabase::class);

test('auth user can store user', function () {
    // Run migrations and seeders
    artisan('migrate:fresh --seed');

    // Create a user and authenticate
    $user = User::factory()->create();
    $user->assignRole('SUPER ADMIN PERENCANAAN');
    actingAs($user);

    // Mocking a request with necessary data
    $requestData = [
        'user_name' => 'John Doe', // matches 'user_name' in UserController
        'email' => 'john@example.com', // matches 'email' in UserController
        'user_role' => 'SUPER ADMIN PERENCANAAN', // matches 'user_role' in UserController
        'identity_number' => '123456789', // matches 'identity_number' in UserController
        'position' => 'Some Position', // matches 'position' in UserController
        'work_unit' => WorkUnit::factory()->create()->id, // matches 'work_unit' in UserController
    ];

    // Sending a POST request to the controller's store method
    $response = post(route('user.store'), $requestData);

    // Asserting that the request was successful
    $response->assertStatus(302); // Assuming a successful redirect

    // Asserting that the user was created in the database
    assertDatabaseHas('users', [
        'name' => $requestData['user_name'],
        'email' => $requestData['email'],
    ]);
});
