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
        $response->assertSee('Dashboard Admin');
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

    public function test_admin_can_create_new_car()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/cars', [
            'brand' => 'Honda',
            'model_type' => 'Civic RS 1.5 Turbo',
            'year' => 2023,
            'color' => 'Merah',
            'transmission' => 'Automatic',
            'plate_number' => 'D 9999 XYZ',
            'price' => 520000000,
            'status' => 'tersedia',
        ]);

        $response->assertRedirect('/cars');
        $this->assertDatabaseHas('cars', [
            'plate_number' => 'D 9999 XYZ',
            'brand' => 'Honda',
        ]);
    }

    public function test_sale_transaction_updates_car_status_to_terjual()
    {
        $admin = User::where('role', 'admin')->first();
        $customer = Customer::first();
        $availableCar = Car::where('status', 'tersedia')->first();

        $response = $this->actingAs($admin)->post('/sales', [
            'car_id' => $availableCar->id,
            'customer_id' => $customer->id,
            'sale_date' => now()->toDateString(),
            'sale_price' => $availableCar->price,
            'payment_method' => 'transfer',
            'notes' => 'Pembayaran via BCA',
        ]);

        $response->assertRedirect('/sales');
        
        // Assert car status changed to TERJUAL
        $this->assertDatabaseHas('cars', [
            'id' => $availableCar->id,
            'status' => 'terjual',
        ]);

        // Assert sale record created
        $this->assertDatabaseHas('sales', [
            'car_id' => $availableCar->id,
            'customer_id' => $customer->id,
        ]);
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
            'payment_method' => 'cash',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_admin_can_upload_car_image_to_public_uploads()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $file = \Illuminate\Http\UploadedFile::fake()->image('test_car.jpg');

        $response = $this->actingAs($admin)->post('/cars', [
            'brand' => 'Toyota',
            'model_type' => 'Yaris Cross',
            'year' => 2024,
            'color' => 'Putih',
            'transmission' => 'Automatic',
            'plate_number' => 'D 7777 UPL',
            'price' => 350000000,
            'status' => 'tersedia',
            'image' => $file,
        ]);

        $response->assertRedirect('/cars');
        $car = Car::where('plate_number', 'D 7777 UPL')->first();
        $this->assertNotNull($car->image);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($car->image);
    }
}
