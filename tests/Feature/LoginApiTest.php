<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login with valid credentials.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Prepare the login data
        $loginData = [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ];

        // Send the POST request to the login route
        $response = $this->postJson('/api/login', $loginData);

        // Assert the response is OK (status 200)
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                ],
                'token',
            ],
        ]);
    }

    /**
     * Test login with invalid credentials.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        // Prepare the login data with invalid credentials
        $loginData = [
            'email' => 'testuser@example.com',
            'password' => 'wrongpassword',
        ];

        // request to the login route
        $response = $this->postJson('/api/login', $loginData);

        // response status is 401 (Unauthorized)
        $response->assertStatus(401);

        // response contains the expected JSON structure
        $response->assertJson([
            'status' => 401,
            'message' => 'Invalid credentials',
        ]);
    }

    /**
     * Test login with missing credentials (missing password).
     *
     * @return void
     */
    public function test_login_with_missing_credentials()
    {
        // login data with missing password
        $loginData = [
            'email' => 'testuser@example.com',
        ];

        // request to the login route
        $response = $this->postJson('/api/login', $loginData);

        // Unprocessable Entity
        $response->assertStatus(422);

        // validation error for 'password'
        $response->assertJsonValidationErrors(['password']);
    }

    /**
     * Test login with unregistered email.
     *
     * @return void
     */
    public function test_login_with_unregistered_email()
    {
        // login data with an unregistered email
        $loginData = [
            'email' => 'nonexistentuser@example.com',
            'password' => 'password123',
        ];

        // request to the login route
        $response = $this->postJson('/api/login', $loginData);

        // Unauthorized
        $response->assertStatus(401);

        // response contains an error message
        $response->assertJson([
            'status' => 401,
            'message' => 'Invalid credentials',
        ]);
    }

    /**
     * Test login with missing email.
     *
     * @return void
     */
    public function test_login_with_missing_email()
    {
        // login data with missing email
        $loginData = [
            'password' => 'password123',
        ];

        // request to the login route
        $response = $this->postJson('/api/login', $loginData);

        // Unprocessable Entity
        $response->assertStatus(422);

        // response contains a validation error for 'email'
        $response->assertJsonValidationErrors(['email']);
    }
}
