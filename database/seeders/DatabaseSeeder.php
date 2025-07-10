<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'apellidos' => 'Deckorativa',
            'telefono' => '12345678',
            'email' => 'admin@deckorativa.com',
            'password' => bcrypt('password'), //Poner la contraseña que prefiera
            'rol' => 'Administrador',
            'estado' => true,
        ]);
    }
}
