<?php

namespace Tests\Feature;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use function PHPSTORM_META\map;

class PositionTest extends TestCase
{
    /** @test */
    public function cannot_get_list_position_with_not_authorized()
    {
        $this->getJson(route('api.position.index'))->assertUnauthorized();
    }

    /** @test */
    public function cannot_get_detail_position_with_not_authorized()
    {
        $this->getJson(route('api.position.show', 1))->assertUnauthorized();
    }

    /** @test */
    public function cannot_create_position_with_not_authorized()
    {
        $this->postJson(route('api.position.store'))->assertUnauthorized();
    }

    /** @test */
    public function cannot_update_position_with_not_authorized()
    {
        $this->putJson(route('api.position.update', 1))->assertUnauthorized();
    }

    /** @test */
    public function cannot_delete_position_with_not_authorized()
    {
        $this->deleteJson(route('api.position.delete', 1))->assertUnauthorized();
    }

    /** @test */
    public function cannot_get_detail_position_with_authorized_and_id_not_found()
    {
        Sanctum::actingAs(User::find(1));

        $this->getJson(route('api.position.show', 1000))->assertNotFound();
    }

    /** @test */
    public function cannot_create_position_with_authorized_and_empty_request()
    {
        Sanctum::actingAs(User::find(1));

        $this->postJson(route('api.position.store'), [
            'position' => '',
            'salary' => ''
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function cannot_update_position_with_authorized_and_empty_request()
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson(route('api.position.update', 1), [
            'position' => '',
            'salary' => ''
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function can_get_list_position_with_authorized()
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson(route('api.position.index'));
        $result = collect($response->json('data'));

        $this->assertTrue($result->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function can_get_detail_position_with_authorized()
    {
        Sanctum::actingAs(User::find(1));

        $response = $this->getJson(route('api.position.show', 1));
        $result = collect($response->json('data'));

        $this->assertTrue($result->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function can_create_position_with_authorized()
    {
        Sanctum::actingAs(User::find(1));

        $this->postJson(route('api.position.store'), [
            'position' => 'Humas',
            'salary' => '5000000'
        ])->assertCreated();

        $position = Position::where('name', 'Humas')->first();
        $this->assertNotNull($position);
    }

    /** @test */
    public function can_update_position_with_authorized()
    {
        Sanctum::actingAs(User::find(1));
        $position = Position::where('name', 'Humas')->first();

        $this->putJson(route('api.position.update', $position->id), [
            'position' => 'Humas Edited',
            'salary' => '5000000'
        ])->assertOk();

        $position = Position::where('name', 'Humas')->first();
        $this->assertNull($position);
        $position = Position::where('name', 'Humas Edited')->first();
        $this->assertNotNull($position);
    }

    /** @test */
    public function can_delete_position_with_authorized()
    {
        Sanctum::actingAs(User::find(1));
        $position = Position::where('name', 'Humas Edited')->first();

        $this->deleteJson(route('api.position.delete', $position->id))->assertOk();

        $position = Position::where('name', 'Humas Edited')->first();
        $this->assertNull($position);
    }
}
