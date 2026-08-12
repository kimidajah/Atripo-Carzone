<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin Operasional',
                'email' => 'admin@atripo.com',
                'password' => Hash::make('4dm1n'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['username' => 'owner'],
            [
                'name' => 'Pemilik Showroom',
                'email' => 'owner@atripo.com',
                'password' => Hash::make('own3r'),
                'role' => 'owner',
                'phone' => '081987654321',
            ]
        );
    }
}
