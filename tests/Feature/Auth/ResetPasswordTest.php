<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\SendEmailActivation;
use App\Notifications\SendEmailVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /** @test */
    public function success_submit_email_for_reset_password()
    {
        Notification::fake();

        $payload = [
            'email' => 'admin@example.com'
        ];

        $user = User::where('email', $payload['email'])->first();

        $this->expectsNotification($user, SendEmailVerification::class);
        $response = $this->postJson(route('api.auth.reset.password'), $payload);

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function failed_reset_password_with_empty_email()
    {
        $payload = [
            'email' => ''
        ];

        $response = $this->postJson(route('api.auth.reset.password'), $payload);

        $response->assertStatus(400);
    }

    /** @test */
    public function failed_reset_password_with_wrong_email()
    {
        $payload = [
            'email' => 'emailnotfound@example.com'
        ];

        $response = $this->postJson(route('api.auth.reset.password'), $payload);

        $response->assertStatus(400);
    }
}
