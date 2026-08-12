<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $customer1 = Customer::first();
        $customer2 = Customer::skip(1)->first();

        // Get cars with status 'terjual'
        $carPajero = Car::where('plate_number', 'D 9012 HIJ')->first();
        $carRocky = Car::where('plate_number', 'D 6789 TUV')->first();

        if ($admin && $carPajero && $customer1) {
            Sale::updateOrCreate(
                ['invoice_number' => 'INV-20260801-001'],
                [
                    'car_id' => $carPajero->id,
                    'customer_id' => $customer1->id,
                    'user_id' => $admin->id,
                    'sale_date' => now()->subDays(10)->format('Y-m-d'),
                    'sale_price' => $carPajero->price,
                    'payment_method' => 'transfer',
                    'notes' => 'Pembayaran lunas via transfer Bank BCA.',
                ]
            );
        }

        if ($admin && $carRocky && $customer2) {
            Sale::updateOrCreate(
                ['invoice_number' => 'INV-20260805-002'],
                [
                    'car_id' => $carRocky->id,
                    'customer_id' => $customer2->id,
                    'user_id' => $admin->id,
                    'sale_date' => now()->subDays(5)->format('Y-m-d'),
                    'sale_price' => $carRocky->price,
                    'payment_method' => 'cash',
                    'notes' => 'Pembayaran tunai di showroom.',
                ]
            );
        }
    }
}
