<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// 1. IMPORTANTE: Importa el Facade DB
use Illuminate\Support\Facades\DB; 

class EstadoHitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Usamos DB::table() para insertar directamente
        DB::table('estados_hitos')->insert([
            ['nombre' => 'Pendiente'],
            ['nombre' => 'En Progreso'],
            ['nombre' => 'Completado'],
        ]);
    }
}