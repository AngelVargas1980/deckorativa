<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero crear permisos y roles
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CategoriaSeeder::class,
            ServicioSeeder::class,
        ]);

        // Solo crear el usuario administrador principal
        if (!User::where('email', 'admin@deckorativa.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'apellidos' => 'Deckorativa',
                'telefono' => '+502 1234 5678',
                'email' => 'admin@deckorativa.com',
                'password' => bcrypt('password'),
                'rol' => 'Admin',
                'estado' => true,
            ]);

            // Asignar el rol Admin
            $admin->assignRole('Admin');
        }
    }
}
