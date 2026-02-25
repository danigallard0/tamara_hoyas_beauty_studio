<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Servicios base del centro (catálogo inicial)
        DB::table('servicios')->insert([
            [
                'nombre' => 'Micropigmentación de cejas',
                'descripcion' => 'Diseño y pigmentación permanente de cejas.',
                'tipo_servicio' => 'micropigmentacion',
                'duracion_min' => 120,
                'precio' => 250.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Micropigmentación de ojos',
                'descripcion' => 'Diseño y pigmentación de eyeliner superior/inferior según diseño.',
                'tipo_servicio' => 'micropigmentacion',
                'duracion_min' => 120,
                'precio' => 220.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Micropigmentación de labios',
                'descripcion' => 'Diseño y pigmentación para definir y dar color a los labios',
                'tipo_servicio' => 'micropigmentacion',
                'duracion_min' => 120,
                'precio' => 280.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Micropigmentación de areolas',
                'descripcion' => 'Diseño, reconstrucción y definición de areolas para pacientes oncológicas.',
                'tipo_servicio' => 'micropigmentacion',
                'duracion_min' => 120,
                'precio' => 300.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Maquillaje profesional',
                'descripcion' => 'Maquillaje para bodas, eventos, inivitadas y sesiones.',
                'tipo_servicio' => 'maquillaje',
                'duracion_min' => 90,
                'precio' => 80.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
