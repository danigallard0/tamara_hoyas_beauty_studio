<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        // 1=Lunes ... 5=Viernes
        $diasLaborales = [1, 2, 3, 4, 5];

        $data = [];

        foreach($diasLaborales as $dia){
            //Mañana
            $data[] = [
                'dia_semana' => $dia,
                'hora_inicio' => '10:00:00',
                'hora_fin' => '14:00:00',
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            //Tarde
             $data[] = [
                'dia_semana' => $dia,
                'hora_inicio' => '16:00:00',
                'hora_fin' => '20:00:00',
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('horarios')->insert($data);
    }
}
