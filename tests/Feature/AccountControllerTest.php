<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_an_registration_requires_email_name_and_password()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }

    public function test_that_user_registers_successfully()
    {
        $user = [
            'name' => 'test_User',
            'email' => 'test_user@test.com',
            'password' => 'test_password',
            'password_confirmation' => 'test_password',
        ];

        $this->json('post', '/api/register', $user, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson(["message" => "Successfully created user!"]);
    }

    public function test_login_requires_email_and_password_to_login()
    {
        $this->json('POST', 'api/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }

    public function test_that_user_with_valid_credentials_login_successfully()
    {
        \Artisan::call('passport:install');
        $user = factory(User::class)->create([
            'email' => 'test_user@test.com',
            'password' => bcrypt('test_password'),
        ]);

        $payload = ['email' => 'test_user@test.com', 'password' => 'test_password'];

        $this->json('POST', 'api/login', $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_at',
                ],
            ]);
    }
}
