<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PedidosPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos para pedidos
        $permissions = [
            'view pedidos',
            'create pedidos',
            'edit pedidos',
            'delete pedidos',
            'change state pedidos',
            'generate pdf pedidos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos al rol Admin
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        $this->command->info('Permisos de pedidos creados y asignados exitosamente.');
    }
}
