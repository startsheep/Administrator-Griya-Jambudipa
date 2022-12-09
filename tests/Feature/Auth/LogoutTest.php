<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function success_logout()
    {
        Sanctum::actingAs(User::find(1), ['super-admin']);

        $response = $this->postJson(route('api.auth.logout'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
