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
        // SOLO los 4 módulos principales

        // Dashboard
        Permission::firstOrCreate(['name' => 'view dashboard']);

        // Roles
        Permission::firstOrCreate(['name' => 'create roles']);
        Permission::firstOrCreate(['name' => 'edit roles']);
        Permission::firstOrCreate(['name' => 'delete roles']);
        Permission::firstOrCreate(['name' => 'view roles']);

        // Usuarios
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'restore users']);

        // Clientes
        Permission::firstOrCreate(['name' => 'create clients']);
        Permission::firstOrCreate(['name' => 'edit clients']);
        Permission::firstOrCreate(['name' => 'delete clients']);
        Permission::firstOrCreate(['name' => 'view clients']);
        Permission::firstOrCreate(['name' => 'view clients readonly']);

        // Categorías
        Permission::firstOrCreate(['name' => 'create categorias']);
        Permission::firstOrCreate(['name' => 'edit categorias']);
        Permission::firstOrCreate(['name' => 'delete categorias']);
        Permission::firstOrCreate(['name' => 'view categorias']);

        // Servicios
        Permission::firstOrCreate(['name' => 'create servicios']);
        Permission::firstOrCreate(['name' => 'edit servicios']);
        Permission::firstOrCreate(['name' => 'delete servicios']);
        Permission::firstOrCreate(['name' => 'view servicios']);

        // Cotizaciones
        Permission::firstOrCreate(['name' => 'create cotizaciones']);
        Permission::firstOrCreate(['name' => 'edit cotizaciones']);
        Permission::firstOrCreate(['name' => 'delete cotizaciones']);
        Permission::firstOrCreate(['name' => 'view cotizaciones']);
        Permission::firstOrCreate(['name' => 'generate pdf cotizaciones']);
        Permission::firstOrCreate(['name' => 'send email cotizaciones']);
        Permission::firstOrCreate(['name' => 'change state cotizaciones']);

        // Pedidos
        Permission::firstOrCreate(['name' => 'create pedidos']);
        Permission::firstOrCreate(['name' => 'view pedidos']);
        Permission::firstOrCreate(['name' => 'edit pedidos']);
        Permission::firstOrCreate(['name' => 'delete pedidos']);

    }
}
