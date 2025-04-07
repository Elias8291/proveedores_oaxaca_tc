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
        // User 1: Specific RFC, active user
        User::updateOrCreate(
            ['email' => 'eliasrj824@gmail.com'],
            [
                'name' => 'Usuario Activo RAJE', // You can modify the name as needed
                'rfc' => 'RAJE020226G97',
                'password' => Hash::make('Abisai1789'),
                'ultimo_acceso' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'active',
            ]
        );

        // User 2: Random RFC, Telcel user
        User::updateOrCreate(
            ['email' => 'telcel' . Str::random(5) . '@example.com'],
            [
                'name' => 'Radiomóvil Dipsa, S.A. de C.V.',
                'rfc' => $this->generateRandomRFC(),
                'password' => Hash::make('telcel1234'),
                'ultimo_acceso' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'active',
            ]
        );

        // User 3: Specific RFC, Jacqueline user
        User::updateOrCreate(
            ['email' => 'jacquempd@gmail.com'],
            [
                'name' => 'JACQUELINE PETRICIA MIGUEL PENSAMIENTO DOMINGUEZ',
                'rfc' => 'MIDJ020222G49',
                'password' => Hash::make('jacque12345'),
                'ultimo_acceso' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'active',
            ]
        );
    }

    // Helper function to generate RANDOM RFC
    private function generateRandomRFC(): string
    {
        $letters = strtoupper(Str::random(4));
        $date = sprintf('%02d%02d%02d', rand(0, 99), rand(1, 12), rand(1, 28));
        $homoclave = strtoupper(Str::random(3));
        return $letters . $date . $homoclave;
    }
}