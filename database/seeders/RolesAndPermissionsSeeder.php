<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar cache de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // =====================
        // Permisos
        // =====================
        $permissions = [
            'ver dashboard',

            // Catálogo (Marcas, Productos, Proveedores)
            'ver catalogo',
            'gestionar catalogo',

            // Locales
            'ver locales',
            'gestionar locales',

            // Pedidos
            'ver pedidos',
            'crear pedidos',
            'aprobar pedidos',

            // Stock
            'ver stock',
            'ajustar stock',
            'gestionar stock',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // =====================
        // Roles
        // =====================
        $admin     = Role::firstOrCreate(['name' => 'admin']);
        $gerente   = Role::firstOrCreate(['name' => 'gerente']);
        $encargado = Role::firstOrCreate(['name' => 'encargado']);

        // =====================
        // Asignación de permisos
        // =====================
        $admin->syncPermissions(Permission::all());

        $gerente->syncPermissions([
            'ver dashboard',
            'ver catalogo',
            'gestionar catalogo',
            'ver pedidos',
            'aprobar pedidos',
            'ver stock',
            'ajustar stock',
        ]);

        $encargado->syncPermissions([
            'ver dashboard',
            'ver pedidos',
            'crear pedidos',
            'ver stock',
        ]);
    }
}
