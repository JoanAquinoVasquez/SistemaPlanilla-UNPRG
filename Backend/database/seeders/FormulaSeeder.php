<?php

namespace Database\Seeders;

use App\Models\Formula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Generar 10 registros de fórmulas
        Formula::factory()->count(10)->create();
    }
}
