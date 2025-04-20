<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create or update Elias Abisai
        $elias = User::updateOrCreate(
            ['email' => 'eliasrj824@gmail.com'],
            [
                'name' => 'Elias Abisai Ramos Jacinto', 
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

        // Assign revisor_1 role to Elias
        $elias->assignRole('revisor_1');

        // Create or update Telcel user
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

        // Create or update Jacqueline
        User::updateOrCreate(
            ['email' => 'jacquempd@gmail.com'],
            [
                'name' => 'JACQUELINE PATRICIA MIGUEL PENSAMIENTO DOMINGUEZ',
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

    private function generateRandomRFC(): string
    {
        $letters = strtoupper(Str::random(4));
        $date = sprintf('%02d%02d%02d', rand(0, 99), rand(1, 12), rand(1, 28));
        $homoclave = strtoupper(Str::random(3));
        return $letters . $date . $homoclave;
    }
}