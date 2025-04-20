<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Deshabilitar restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vaciar las tablas de roles y permisos para evitar conflictos con IDs
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        // Rehabilitar restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Definir permisos
        $permissions = [
            'gestionar usuarios', // Administrador
            'editar usuarios',    // Administrador
            'ver usuarios',      // Administrador, Revisor 1, Revisor 2
            'revisar documentos', // Revisor 1, Revisor 2
            'aprobar documentos', // Revisor 1
            'rechazar documentos', // Revisor 1
            'gestionar tramites', // Solicitante
            'ver tramites',       // Solicitante, Proveedor
            'gestionar inventario', // Proveedor
            'ver inventario',     // Proveedor, Solicitante
        ];

        // Crear permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles en orden específico para controlar los IDs
        $roles = [
            // ID 1
            'administrador' => [
                'gestionar usuarios',
                'editar usuarios',
                'ver usuarios',
                'revisar documentos',
                'aprobar documentos',
                'rechazar documentos',
                'gestionar tramites',
                'ver tramites',
                'gestionar inventario',
                'ver inventario',
            ],
            // ID 2
            'solicitante' => [
                'gestionar tramites',
                'ver tramites',
                'ver inventario',
            ],
            // ID 3
            'revisor_1' => [
                'ver usuarios',
                'revisar documentos',
                'aprobar documentos',
                'rechazar documentos',
            ],
            // ID 4
            'revisor_2' => [
                'ver usuarios',
                'revisar documentos',
            ],
            // ID 5
            'proveedor' => [
                'ver tramites',
                'gestionar inventario',
                'ver inventario',
            ],
        ];

        // Crear roles y asignar permisos
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]); // Usamos create para generar IDs secuenciales
            $role->syncPermissions($rolePermissions);
        }
    }
}