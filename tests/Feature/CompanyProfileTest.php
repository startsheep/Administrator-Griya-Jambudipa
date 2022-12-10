<?php

namespace Tests\Feature;

use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    /** @test */
    public function can_get_detail_company_profile_with_not_authorized()
    {
        $result = $this->getJson(route('api.company.profile.index'));
        $this->assertTrue(collect($result->json())->count() > 0);

        $result->assertOk();
    }

    /** @test */
    public function cannot_update_detail_company_profile_with_not_authorized()
    {
        $this->putJson(route('api.company.profile.update', 1))->assertUnauthorized();
    }

    /** @test */
    public function can_update_detail_company_profile_with_authorized()
    {
        Sanctum::actingAs(User::find(1));
        Storage::fake('company_profile');
        $logo = UploadedFile::fake()->image('logo.png');

        $this->putJson(route('api.company.profile.update', 1), [
            'name' => 'Edited',
            'email' => 'admin@mailiantor.com',
            'phone' => '12121212',
            'url' => 'http://coba.test',
            'address' => 'edited',
            'logo' => $logo
        ])->assertOk();

        $companyProfile = CompanyProfile::where('name', 'Edited')->first();
        $this->assertNotNull($companyProfile);
    }

    /** @test */
    public function failed_update_detail_company_profile_with_authorized_and_empty_request()
    {
        Sanctum::actingAs(User::find(1));

        $this->putJson(route('api.company.profile.update', 1), [
            'name' => '',
            'email' => '',
            'phone' => '',
            'url' => '',
            'address' => '',
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
