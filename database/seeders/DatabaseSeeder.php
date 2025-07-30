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

        // Crear un usuario Supervisor si no existe
        if (!User::where('email', 'supervisor@deckorativa.com')->exists()) {
            $supervisor = User::create([
                'name' => 'Supervisor',
                'apellidos' => 'Deckorativa',
                'telefono' => '23456789',
                'email' => 'supervisor@deckorativa.com',
                'password' => bcrypt('password'),
                'rol' => 'Supervisor',  // Asignamos el rol de Supervisor
                'estado' => true,
            ]);
            $supervisor->assignRole('Supervisor'); // Asigna el rol Supervisor al usuario
        }

        // Crear un usuario Asesor si no existe
        if (!User::where('email', 'asesor@deckorativa.com')->exists()) {
            $asesor = User::create([
                'name' => 'Asesor',
                'apellidos' => 'Deckorativa',
                'telefono' => '34567890',
                'email' => 'asesor@deckorativa.com',
                'password' => bcrypt('password'),
                'rol' => 'Asesor',  // Asignamos el rol de Asesor
                'estado' => true,
            ]);
            $asesor->assignRole('Asesor'); // Asigna el rol Asesor al usuario
        }

        // Crear un usuario Supervisor si no existe
        if (!User::where('email', 'job@gmail.com')->exists()) {
            $asesor = User::create([
                'name' => 'job',
                'apellidos' => 'izales',
                'telefono' => '12345678',
                'email' => 'job@gmail.com',
                'password' => bcrypt('password'),
                'rol' => 'Supervisor',  // Asignamos el rol de Asesor
                'estado' => true,
            ]);
            $supervisor->assignRole('Supervisor'); // Asigna el rol Asesor al usuario
        }


        // Crear un usuario Asesor si no existe
        if (!User::where('email', 'henry@gmail.com')->exists()) {
            $asesor = User::create([
                'name' => 'henry',
                'apellidos' => 'zacarias',
                'telefono' => '12345678',
                'email' => 'henry@gmail.com',
                'password' => bcrypt('password'),
                'rol' => 'Asesor',  // Asignamos el rol de Asesor
                'estado' => true,
            ]);
            $asesor->assignRole('Asesor'); // Asigna el rol Asesor al usuario
        }

        // Llamar el seeder de roles
        $this->call(RoleSeeder::class); //

    }
}
