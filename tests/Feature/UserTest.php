<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test store function in UserController.
     *
     * @return void
     */
    public function testAuthUserStoreUser()
    {
        // Run migrations and seeders
        $this->artisan('migrate:fresh --seed');

        // Create a user and authenticate
        $user = User::factory()->create()->assignRole('SUPER ADMIN PERENCANAAN');
        $this->actingAs($user);

        // Mocking a request with necessary data
        $requestData = [
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'user_role' => 'SUPER ADMIN PERENCANAAN',
            // Add identity_number to make 'position' and 'work_unit' required
            'identity_number' => '123456789',
            'position' => 'Some Position',
            'work_unit' => WorkUnit::factory()->create()->id,
        ];

        // Sending a POST request to the controller's store method
        $response = $this->post(route('user.store'), $requestData);

        // Asserting that the request was successful
        $response->assertStatus(302); // Assuming a successful redirect
        $response->assertSessionHas('success', 'Data user berhasil ditambahkan.');

        // Asserting that the user was created in the database
        $this->assertDatabaseHas('users', [
            'name' => $requestData['user_name'],
            'email' => $requestData['user_email'],
        ]);
    }
}
