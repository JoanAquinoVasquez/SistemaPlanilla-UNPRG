<?php

namespace Database\Seeders;

use App\Models\Parametro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Generar 10 parámetros, cada uno asociado a un documento
        Parametro::factory()->count(10)->create();
    }
}
