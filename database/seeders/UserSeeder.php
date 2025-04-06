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
        // New inactive user
        User::updateOrCreate(
            ['email' => 'inactive' . Str::random(5) . '@example.com'],
            [
                'name' => 'Usuario Inactivo ' . Str::random(8),
                'rfc' => $this->generateRandomRFC(),
                'password' => Hash::make('Inactive2025'),
                'ultimo_acceso' => now()->subDays(rand(31, 90)), // Last access older than active users
                'email_verified_at' => now()->subDays(rand(31, 90)),
                'remember_token' => Str::random(10),
                'created_at' => now()->subDays(rand(61, 120)),
                'updated_at' => now()->subDays(rand(31, 90)),
                'status' => 'inactive',
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