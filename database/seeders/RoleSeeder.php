<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $roles = [
            ['name' => 'administrador', 'guard_name' => 'web'],
            ['name' => 'tramitante', 'guard_name' => 'web'],
            ['name' => 'proveedor', 'guard_name' => 'web'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['guard_name' => $roleData['guard_name']]
            );
        }
    }
}