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

        // Clientes
        Permission::firstOrCreate(['name' => 'create clients']);
        Permission::firstOrCreate(['name' => 'edit clients']);
        Permission::firstOrCreate(['name' => 'delete clients']);
        Permission::firstOrCreate(['name' => 'view clients']);
        Permission::firstOrCreate(['name' => 'view clients readonly']);
    }
}
