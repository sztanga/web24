<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_create_employee()
    {
        $company = Company::factory()->create();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '1234567890',
            'company_id' => $company->id,
        ];

        $response = $this->postJson('/api/employees', $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('employees', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'company_id' => $data['company_id'],
        ]);
    }

    public function test_can_get_all_employees()
    {
        $company = Company::factory()->create();
        Employee::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson('/api/employees');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3);
    }

    public function test_can_get_single_employee()
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson('/api/employees/' . $employee->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['first_name' => $employee->first_name]);
    }

    public function test_can_update_employee()
    {
        $company = Company::factory()->create();

        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'phone_number' => '0987654321',
            'company_id' => $company->id,
        ];

        $response = $this->putJson("/api/employees/{$employee->id}", $data);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'company_id' => $data['company_id'],
        ]);
    }

    public function test_can_delete_employee()
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson('/api/employees/' . $employee->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNotNull($employee->fresh()->deleted_at);
    }
}
