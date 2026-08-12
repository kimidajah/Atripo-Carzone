<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model_type' => 'Avanza 1.5 G CVT',
                'year' => 2022,
                'color' => 'Hitam Metalik',
                'transmission' => 'Automatic',
                'plate_number' => 'D 1234 ABC',
                'price' => 215000000,
                'status' => 'tersedia',
            ],
            [
                'brand' => 'Honda',
                'model_type' => 'HR-V 1.5 E CVT',
                'year' => 2021,
                'color' => 'Putih Mutiara',
                'transmission' => 'Automatic',
                'plate_number' => 'D 5678 EFG',
                'price' => 310000000,
                'status' => 'tersedia',
            ],
            [
                'brand' => 'Mitsubishi',
                'model_type' => 'Pajero Sport Dakar 4x2',
                'year' => 2020,
                'color' => 'Hitam',
                'transmission' => 'Automatic',
                'plate_number' => 'D 9012 HIJ',
                'price' => 485000000,
                'status' => 'terjual',
            ],
            [
                'brand' => 'Toyota',
                'model_type' => 'Innova Reborn 2.4 V Diesel',
                'year' => 2021,
                'color' => 'Abu-abu Metalik',
                'transmission' => 'Automatic',
                'plate_number' => 'D 3456 KLM',
                'price' => 375000000,
                'status' => 'tersedia',
            ],
            [
                'brand' => 'Honda',
                'model_type' => 'Brio RS 1.2 CVT',
                'year' => 2023,
                'color' => 'Kuning',
                'transmission' => 'Automatic',
                'plate_number' => 'D 7890 NOP',
                'price' => 180000000,
                'status' => 'dipesan',
            ],
            [
                'brand' => 'Suzuki',
                'model_type' => 'XL7 Alpha AT',
                'year' => 2022,
                'color' => 'Orange/Black',
                'transmission' => 'Automatic',
                'plate_number' => 'D 2345 QRS',
                'price' => 235000000,
                'status' => 'tersedia',
            ],
            [
                'brand' => 'Daihatsu',
                'model_type' => 'Rocky 1.0 R Turbo CVT',
                'year' => 2021,
                'color' => 'Merah',
                'transmission' => 'Automatic',
                'plate_number' => 'D 6789 TUV',
                'price' => 195000000,
                'status' => 'terjual',
            ],
            [
                'brand' => 'Toyota',
                'model_type' => 'Fortuner 2.8 VRZ 4x2',
                'year' => 2022,
                'color' => 'Hitam',
                'transmission' => 'Automatic',
                'plate_number' => 'D 1122 WXY',
                'price' => 540000000,
                'status' => 'tersedia',
            ],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(
                ['plate_number' => $car['plate_number']],
                $car
            );
        }
    }
}
