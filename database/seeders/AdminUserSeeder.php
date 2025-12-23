<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Crear o buscar rol Administrador
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);

        // Crear o buscar usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@vet.com.py'],
            [
                'name' => 'Administrador',
                'password' => Hash::make(env('ADMIN_PASSWORD'))
            ]
        );

        // Asignar rol (evita duplicados)
        if (!$admin->hasRole('Administrador')) {
            $admin->assignRole($adminRole);
        }
    }
}
