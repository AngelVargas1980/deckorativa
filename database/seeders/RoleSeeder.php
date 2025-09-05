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
        // Solo crear rol Admin
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Asignar todos los permisos al Admin
        $adminRole->givePermissionTo(Permission::all());
    }
}
