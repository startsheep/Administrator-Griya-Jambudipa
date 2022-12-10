<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test   */
    public function user_success_login_with_correct_password_and_email()
    {
        $payload = [
            'email' => 'admin@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson(route('api.auth.login'), $payload);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function failed_login_with_empty_request()
    {
        $payload = [
            'email' => '',
            'password' => ''
        ];

        $response = $this->postJson(route('api.auth.login'), $payload);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function failed_login_with_wrong_email()
    {
        $payload = [
            'email' => 'asep@mail.com',
            'password' => 'password'
        ];

        $response = $this->postJson(route('api.auth.login'), $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function failed_login_with_wrong_password()
    {
        $payload = [
            'email' => 'admin@example.com',
            'password' => 'pasdfdfdfds'
        ];

        $response = $this->postJson(route('api.auth.login'), $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
