<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $asesorRole = Role::firstOrCreate(['name' => 'Asesor']);
        $supervisorRole = Role::firstOrCreate(['name' => 'Supervisor']);

        // Crear permisos si no existen
        $permissions = [
            'create roles', 'edit roles', 'delete roles', 'view roles',
            'create users', 'edit users', 'delete users', 'view users',
            'create productos', 'edit productos', 'delete productos', 'view productos',
            'create pedidos', 'edit pedidos', 'delete pedidos', 'view pedidos',
            'create cotizador', 'edit cotizador', 'delete cotizador', 'view cotizador'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a los roles
        $adminRole->givePermissionTo([
            'create roles', 'edit roles', 'delete roles', 'view roles',
            'view users', 'create users', 'edit users', 'delete users',
            'create productos', 'edit productos', 'delete productos', 'view productos',
            'create pedidos', 'edit pedidos', 'delete pedidos', 'view pedidos',
            'create cotizador', 'edit cotizador', 'delete cotizador', 'view cotizador'
        ]);

        $asesorRole->givePermissionTo([
            'view productos', 'view pedidos', 'view cotizador', // Asesor puede ver
            'view users',
        ]);

        $supervisorRole->givePermissionTo([
            'create productos', 'edit productos', 'view productos',
            'create pedidos', 'edit pedidos', 'view pedidos',
            'view users',
        ]);
    }
}
