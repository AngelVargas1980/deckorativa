<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            // Decoración Interior
            [
                'nombre' => 'Diseño de Sala',
                'descripcion' => 'Diseño completo de sala de estar con selección de mobiliario y accesorios',
                'precio' => 2500.00,
                'tipo' => 'servicio',
                'categoria_id' => 1,
                'tiempo_estimado' => 480, // 8 horas
                'unidad_medida' => 'servicio',
                'activo' => true
            ],
            [
                'nombre' => 'Cortinas Personalizadas',
                'descripcion' => 'Cortinas diseñadas a medida con telas premium',
                'precio' => 450.00,
                'tipo' => 'producto',
                'categoria_id' => 1,
                'unidad_medida' => 'metro',
                'activo' => true
            ],
            [
                'nombre' => 'Diseño de Dormitorio',
                'descripcion' => 'Diseño integral de dormitorio principal con mobiliario',
                'precio' => 3200.00,
                'tipo' => 'servicio',
                'categoria_id' => 1,
                'tiempo_estimado' => 600, // 10 horas
                'unidad_medida' => 'servicio',
                'activo' => true
            ],
            
            // Decoración Exterior
            [
                'nombre' => 'Diseño de Jardín',
                'descripcion' => 'Diseño paisajístico completo de jardín con plantas y decoración',
                'precio' => 1800.00,
                'tipo' => 'servicio',
                'categoria_id' => 2,
                'tiempo_estimado' => 720, // 12 horas
                'unidad_medida' => 'servicio',
                'activo' => true
            ],
            [
                'nombre' => 'Fuente Decorativa',
                'descripcion' => 'Fuente de agua decorativa para exteriores',
                'precio' => 850.00,
                'tipo' => 'producto',
                'categoria_id' => 2,
                'unidad_medida' => 'unidad',
                'activo' => true
            ],
            
            // Eventos y Celebraciones
            [
                'nombre' => 'Decoración de Boda',
                'descripcion' => 'Decoración completa para ceremonia y recepción de boda',
                'precio' => 4500.00,
                'tipo' => 'servicio',
                'categoria_id' => 3,
                'tiempo_estimado' => 960, // 16 horas
                'unidad_medida' => 'evento',
                'activo' => true
            ],
            [
                'nombre' => 'Centro de Mesa Premium',
                'descripcion' => 'Centro de mesa elegante con flores naturales',
                'precio' => 125.00,
                'tipo' => 'producto',
                'categoria_id' => 3,
                'unidad_medida' => 'unidad',
                'activo' => true
            ],
            
            // Mobiliario y Accesorios
            [
                'nombre' => 'Sofá 3 Plazas Premium',
                'descripcion' => 'Sofá de tres plazas en cuero genuino con diseño moderno',
                'precio' => 3200.00,
                'tipo' => 'producto',
                'categoria_id' => 5,
                'unidad_medida' => 'unidad',
                'activo' => true
            ],
            [
                'nombre' => 'Mesa de Centro de Vidrio',
                'descripcion' => 'Mesa de centro con superficie de vidrio templado y base metálica',
                'precio' => 650.00,
                'tipo' => 'producto',
                'categoria_id' => 5,
                'unidad_medida' => 'unidad',
                'activo' => true
            ],
            
            // Decoración Comercial
            [
                'nombre' => 'Diseño de Oficina',
                'descripcion' => 'Diseño integral de espacios de oficina para empresas',
                'precio' => 2800.00,
                'tipo' => 'servicio',
                'categoria_id' => 4,
                'tiempo_estimado' => 720, // 12 horas
                'unidad_medida' => 'servicio',
                'activo' => true
            ]
        ];

        foreach ($servicios as $servicio) {
            \App\Models\Servicio::create($servicio);
        }
    }
}
