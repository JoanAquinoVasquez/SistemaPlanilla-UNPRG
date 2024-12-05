<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleFamilia;

class DetalleFamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DetalleFamilia::factory(50)->create(); // Generará 50 registros de prueba en detalle_familias
    }
}
