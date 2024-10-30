<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_create_company()
    {
        $data = [
            'name' => 'Test Company',
            'NIP' => '1234567890',
            'address' => '123 Test St',
            'city' => 'Test City',
            'postal_code' => '12345',
        ];

        $response = $this->postJson('/api/companies', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('companies', $data);
    }

    public function test_can_get_all_companies()
    {
        Company::factory()->count(3)->create();

        $response = $this->getJson('/api/companies');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3);
    }

    public function test_can_get_single_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson('/api/companies/' . $company->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['name' => $company->name]);
    }

    public function test_can_update_company()
    {
        $company = Company::factory()->create();
        $data = [
            'name' => 'Updated Company',
            'NIP' => '0987654321',
            'address' => '456 Updated St',
            'city' => 'Updated City',
            'postal_code' => '54321',
        ];

        $response = $this->putJson('/api/companies/' . $company->id, $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('companies', $data);
    }

    public function test_can_delete_company()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson('/api/companies/' . $company->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNotNull($company->fresh()->deleted_at);
    }
}
