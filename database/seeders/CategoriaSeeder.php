<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Decoración Interior',
                'descripcion' => 'Servicios y productos para decoración de interiores de hogares y oficinas',
                'activo' => true
            ],
            [
                'nombre' => 'Decoración Exterior',
                'descripcion' => 'Servicios para decoración de jardines, patios y fachadas',
                'activo' => true
            ],
            [
                'nombre' => 'Eventos y Celebraciones',
                'descripcion' => 'Decoración especializada para bodas, cumpleaños y eventos especiales',
                'activo' => true
            ],
            [
                'nombre' => 'Decoración Comercial',
                'descripcion' => 'Servicios de decoración para locales comerciales y oficinas',
                'activo' => true
            ],
            [
                'nombre' => 'Mobiliario y Accesorios',
                'descripcion' => 'Muebles y accesorios decorativos de alta calidad',
                'activo' => true
            ]
        ];

        foreach ($categorias as $categoria) {
            \App\Models\Categoria::create($categoria);
        }
    }
}
