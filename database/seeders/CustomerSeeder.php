<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'phone' => '081223344556',
                'address' => 'Jl. Rayas Cileunyi No. 45, Bandung',
                'email' => 'budi.santoso@gmail.com',
            ],
            [
                'name' => 'Ahmad Rifa\'i',
                'phone' => '085711223344',
                'address' => 'Jl. Soekarno Hatta No. 120, Bandung',
                'email' => 'ahmad.rifai@yahoo.com',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'phone' => '087899887766',
                'address' => 'Komplek Permata Biru Blok B No. 12, Cinunuk, Cileunyi',
                'email' => 'siti.nurhaliza@gmail.com',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'phone' => '082133445566',
                'address' => 'Jl. Raya Rancaekek No. 88, Sumedang',
                'email' => 'dedi.k@hotmail.com',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['phone' => $customer['phone']],
                $customer
            );
        }
    }
}
