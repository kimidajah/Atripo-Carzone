<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowroomSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_welcome_page_displays_only_available_cars()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Armada Mobil Tersedia');
        $response->assertSee('TERSEDIA');
        $response->assertDontSee('TERJUAL');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => '4dm1n',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_dashboard_access()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Operasional');
    }

    public function test_owner_dashboard_access()
    {
        $owner = User::where('role', 'owner')->first();

        $response = $this->actingAs($owner)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Monitoring Pemilik');
    }

    public function test_owner_cannot_access_car_create_page()
    {
        $owner = User::where('role', 'owner')->first();

        $response = $this->actingAs($owner)->get('/cars-create');
        $response->assertStatus(403);
    }

    public function test_pengelola_can_access_car_create_page_and_create_car()
    {
        $pengelola = User::where('role', 'pengelola')->first();

        $response = $this->actingAs($pengelola)->get('/cars-create');
        $response->assertStatus(200);

        $response = $this->actingAs($pengelola)->post('/cars', [
            'brand' => 'Honda',
            'model_type' => 'HR-V SE 1.5',
            'year' => 2023,
            'color' => 'Hitam',
            'transmission' => 'Automatic',
            'plate_number' => 'D 8888 PNG',
            'price' => 380000000,
            'status' => 'pending',
        ]);

        $response->assertRedirect('/cars');
        $this->assertDatabaseHas('cars', [
            'plate_number' => 'D 8888 PNG',
            'status' => 'pending',
        ]);
    }

    public function test_marketing_can_create_customer_and_sale()
    {
        $marketing = User::where('role', 'marketing')->first();
        $availableCar = Car::where('status', 'tersedia')->first();

        // Create Customer
        $customerResponse = $this->actingAs($marketing)->post('/customers', [
            'name' => 'Budi Marketing Client',
            'phone' => '08123443211',
            'address' => 'Jl. Kebon Sirih No. 10',
            'email' => 'budi@test.com',
        ]);

        $customerResponse->assertRedirect('/customers');
        $customer = Customer::where('name', 'Budi Marketing Client')->first();
        $this->assertNotNull($customer);

        // Create Sale
        $saleResponse = $this->actingAs($marketing)->post('/sales', [
            'car_id' => $availableCar->id,
            'customer_id' => $customer->id,
            'sale_date' => now()->toDateString(),
            'sale_price' => $availableCar->price,
            'payment_type' => 'cash',
            'payment_method' => 'transfer',
            'notes' => 'Pembayaran lunas via transfer',
        ]);

        $saleResponse->assertRedirect('/sales');
        $this->assertDatabaseHas('sales', [
            'car_id' => $availableCar->id,
            'customer_id' => $customer->id,
        ]);
    }

    public function test_marketing_can_access_sales_report()
    {
        $marketing = User::where('role', 'marketing')->first();

        $response = $this->actingAs($marketing)->get('/reports/sales');
        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan');
    }

    public function test_pengelola_can_access_management_report()
    {
        $pengelola = User::where('role', 'pengelola')->first();

        $response = $this->actingAs($pengelola)->get('/reports/management');
        $response->assertStatus(200);
        $response->assertSee('Laporan Pengelolaan Armada');
    }

    public function test_marketing_cannot_access_car_create_page()
    {
        $marketing = User::where('role', 'marketing')->first();

        $response = $this->actingAs($marketing)->get('/cars-create');
        $response->assertStatus(403);
    }

    public function test_pengelola_cannot_access_sales_create_page()
    {
        $pengelola = User::where('role', 'pengelola')->first();

        $response = $this->actingAs($pengelola)->get('/sales-create');
        $response->assertStatus(403);
    }

    public function test_cannot_sell_already_sold_car()
    {
        $admin = User::where('role', 'admin')->first();
        $customer = Customer::first();
        $soldCar = Car::where('status', 'terjual')->first();

        $response = $this->actingAs($admin)->post('/sales', [
            'car_id' => $soldCar->id,
            'customer_id' => $customer->id,
            'sale_date' => now()->toDateString(),
            'sale_price' => $soldCar->price,
            'payment_type' => 'cash',
            'payment_method' => 'cash',
        ]);

        $response->assertSessionHas('error');
    }
}
