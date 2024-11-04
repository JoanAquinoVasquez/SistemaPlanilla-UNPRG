<?php

namespace Database\Seeders;

use App\Models\FormulaParametro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulaParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Crear 10 registros en la tabla formula_parametro
        FormulaParametro::factory()->count(10)->create();
    }
}
