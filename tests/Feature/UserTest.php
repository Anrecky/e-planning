<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated_cant_see_manage_user_page(): void
    {
        $response = $this->get(route('user.index'));

        $response->assertStatus(302);
    }

    public function testAuthUserCanSeeManageUserPage()
    {
        // Create a test user
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        // Make a request to the route that displays the manage user page
        $response = $this->get(route('user.index'));

        // Assert that the response is successful (status code 200)
        $response->assertStatus(200);

        // Optionally, you can also assert that the response contains specific text or elements to ensure that the correct page is displayed
        $response->assertSee('Kelola User');
    }
}
