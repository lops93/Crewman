<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can return all employees', function () {
    $employees = Employee::factory()->count(5)->create();
    $response = $this->get('/api/employees');
    $response->assertStatus(200)->assertJson($employees->toArray());
});

it('can create an employee', function () {
    $employee = Employee::factory()->raw();
    $response = $this->postJson('/api/employees', $employee);
    $response->assertStatus(200);
    $this->assertDatabaseHas('employees', $employee);
});

it('can show an employee', function () {
    $employee = Employee::factory()->create();
    $response = $this->get("/api/employees/{$employee->id}");
    $response->assertStatus(200)->assertJson($employee->toArray());
});

it('can update an employee', function () {
    $employee = Employee::factory()->create();
    $updatedEmployee = ['first_name' => 'test', 'last_name' => 'test', 'identification_number' => 'ZID12345'];
    $response = $this->putJson("/api/employees/{$employee->id}", $updatedEmployee);
    $response->assertStatus(200);
    $this->assertDatabaseHas('employees', $updatedEmployee);
});

it('can delete an employee', function () {
    $employee = Employee::factory()->create();
    $response = $this->delete("/api/employees/{$employee->id}");
    $response->assertStatus(200);
    $this->assertSoftDeleted($employee);
});
