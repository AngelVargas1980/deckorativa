<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Módulo Roles
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'view roles']);

        // Módulo Usuarios
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);

        // Módulo Productos
        Permission::create(['name' => 'create productos']);
        Permission::create(['name' => 'edit productos']);
        Permission::create(['name' => 'delete productos']);
        Permission::create(['name' => 'view productos']);

        // Módulo Pedidos
        Permission::create(['name' => 'create pedidos']);
        Permission::create(['name' => 'edit pedidos']);
        Permission::create(['name' => 'delete pedidos']);
        Permission::create(['name' => 'view pedidos']);

        // Módulo Cotizador
        Permission::create(['name' => 'create cotizador']);
        Permission::create(['name' => 'edit cotizador']);
        Permission::create(['name' => 'delete cotizador']);
        Permission::create(['name' => 'view cotizador']);

    }
}
