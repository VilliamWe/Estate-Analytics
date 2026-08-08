<?php

namespace Tests\Feature\Feature;

use App\Models\District;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $employee;
    protected PropertyType $propertyType;
    protected District $district;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->employee = User::factory()->create([
            'role' => 'employee',
        ]);

        $this->propertyType = PropertyType::create([
            'title' => 'Офис',
        ]);

        $this->district = District::create([
            'title' => 'Центральный',
        ]);
    }

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_open_properties_index(): void
    {
        $response = $this->actingAs($this->employee)->get(route('properties.index'));

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_property(): void
    {
        $response = $this->actingAs($this->employee)->post(route('properties.store'), [
            'title' => 'Тестовый объект',
            'property_type_id' => $this->propertyType->id,
            'district_id' => $this->district->id,
            'segment' => 'B+',
            'address' => 'ул. Ленина, 1',
            'area' => 100,
            'price' => 10000000,
            'status' => 'Активный',
            'responsible_user_id' => $this->employee->id,
            'description' => 'Описание объекта',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'title' => 'Тестовый объект',
            'address' => 'ул. Ленина, 1',
            'status' => 'Активный',
        ]);
    }

    public function test_invalid_property_status_is_rejected(): void
    {
        $response = $this->actingAs($this->employee)
            ->from(route('properties.create'))
            ->post(route('properties.store'), [
                'title' => 'Тестовый объект',
                'property_type_id' => $this->propertyType->id,
                'district_id' => $this->district->id,
                'address' => 'ул. Ленина, 1',
                'area' => 100,
                'price' => 10000000,
                'status' => 'Несуществующий статус',
                'responsible_user_id' => $this->employee->id,
            ]);

        $response->assertRedirect(route('properties.create'));
        $response->assertSessionHasErrors('status');
    }

    public function test_employee_cannot_access_users_section(): void
    {
        $response = $this->actingAs($this->employee)->get(route('users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_users_section(): void
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_employee_cannot_access_imports_section(): void
    {
        $response = $this->actingAs($this->employee)->get(route('imports.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_imports_section(): void
    {
        $response = $this->actingAs($this->admin)->get(route('imports.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_delete_another_admin_through_interface(): void
    {
        $anotherAdmin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('users.destroy', $anotherAdmin));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $anotherAdmin->id]);
    }
}
