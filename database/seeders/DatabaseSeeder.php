<?php

namespace Database\Seeders;
use Database\Seeders\RoleSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@deckorativa.com')->exists()) {
            $user = User::create([
                'name' => 'Admin',
                'apellidos' => 'Deckorativa',
                'telefono' => '12345678',
                'email' => 'admin@deckorativa.com',
                'password' => bcrypt('password'),
                'rol' => 'Administrador', // Esto es temporal, luego lo eliminaremos
                'estado' => true,
            ]);

            $user->assignRole('Admin'); // 👈 Aquí asignamos el rol real de Spatie
        }

        // Llamar el seeder de roles
        $this->call(RoleSeeder::class); //

    }
}
