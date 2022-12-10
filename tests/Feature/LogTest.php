<?php

namespace Tests\Feature;

use App\Models\Log;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogTest extends TestCase
{
    /** @test */
    public function cannot_get_list_log_with_not_authorized()
    {
        $this->getJson(route('api.log.index'))->assertUnauthorized();
    }

    /** @test */
    public function can_get_list_log_with_authorized()
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson(route('api.log.index'));

        $logs = collect($response->json('data'));
        $this->assertTrue($logs->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function cannot_get_detail_log_with_not_authorized()
    {
        $this->getJson(route('api.log.show', 1))->assertUnauthorized();
    }

    /** @test */
    public function can_get_detail_log_with_authorized()
    {
        Sanctum::actingAs(User::find(1));
        $log = Log::first();
        $response = $this->getJson(route('api.log.show', $log->id));

        $log = collect($response->json());
        $this->assertTrue($log->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function can_get_detail_log_with_authorized_and_id_not_found()
    {
        Sanctum::actingAs(User::find(1));
        $response = $this->getJson(route('api.log.show', 1));

        $response->assertNotFound();
    }
}
