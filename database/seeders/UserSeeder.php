<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'eliasr32j824@gmail.com'],
            [
                'name' => 'Elias Abisai Ramos Jacinto',
                'rfc' => 'EARS820312ABC',
                'password' => Hash::make('Elias1234'),
                'ultimo_acceso' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'prueba@proveedor.com'],
            [
                'name' => 'Usuario de Prueba',
                'rfc' => 'XAXX010101000', 
                'password' => Hash::make('Password123'),
                'ultimo_acceso' => now()->subDays(5),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(2),
            ]
        );

        User::updateOrCreate(
            ['email' => 'otro@proveedor.com'],
            [
                'name' => 'Otro Proveedor',
                'rfc' => 'PERJ890405XYZ',
                'password' => Hash::make('Proveedor2023'),
                'ultimo_acceso' => now()->subDays(15),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(3),
            ]
        );
    }
}