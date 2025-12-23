<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Roles
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $veterinario = Role::firstOrCreate(['name' => 'Veterinario']);
        $recepcionista = Role::firstOrCreate(['name' => 'Recepcionista']);
        $cajero = Role::firstOrCreate(['name' => 'Cajero']);
        $dueno = Role::firstOrCreate(['name' => 'Dueño']);
        
        // Permisos
        $permissions = [
            // Citas
            'ver_citas',
            'crear_citas',
            'editar_citas',
            'eliminar_citas',

            // Mascotas y clientes
            'ver_clientes',
            'crear_clientes',
            'editar_clientes',

            // Historia clínica
            'ver_historial',
            'editar_historial',

            // Facturación
            'ver_facturacion',
            'crear_factura',

            // Stock
            'ver_stock',
            'editar_stock',

            // Reportes
            'ver_reportes',

            // Usuarios
            'gestionar_usuarios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all());

        $veterinario->givePermissionTo([
            'ver_citas',
            'ver_clientes',
            'ver_historial',
            'editar_historial',
            'ver_stock',
        ]);

        $recepcionista->givePermissionTo([
            'ver_citas',
            'crear_citas',
            'editar_citas',
            'ver_clientes',
            'crear_clientes',
        ]);

        $cajero->givePermissionTo([
            'ver_facturacion',
            'crear_factura',
            'ver_reportes',
        ]);

        $dueno->givePermissionTo([
            'ver_reportes',
        ]);

    }
}
