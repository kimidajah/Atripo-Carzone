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
                'email' => 'admin@mobilq.com',
                'password' => Hash::make('4dm1n'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['username' => 'owner'],
            [
                'name' => 'Pemilik Showroom',
                'email' => 'owner@mobilq.com',
                'password' => Hash::make('own3r'),
                'role' => 'owner',
                'phone' => '081987654321',
            ]
        );

        User::updateOrCreate(
            ['username' => 'marketing'],
            [
                'name' => 'Staff Marketing',
                'email' => 'marketing@mobilq.com',
                'password' => Hash::make('m4rk3t1ng'),
                'role' => 'marketing',
                'phone' => '081345678901',
            ]
        );

        User::updateOrCreate(
            ['username' => 'pengelola'],
            [
                'name' => 'Pengelola Mobil',
                'email' => 'pengelola@mobilq.com',
                'password' => Hash::make('p3ng3lol4'),
                'role' => 'pengelola',
                'phone' => '081456789012',
            ]
        );
    }
}
