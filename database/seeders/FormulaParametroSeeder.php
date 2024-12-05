<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaParametro;
use App\Models\Formula;
use App\Models\Parametro;

class FormulaParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todas las fórmulas y parámetros
        $formulas = Formula::all();
        $parametros = Parametro::all();

        // Crear combinaciones de fórmula y parámetro con operaciones
        foreach ($formulas as $formula) {
            foreach ($parametros as $parametro) {
                FormulaParametro::create([
                    'formula_id' => $formula->id,
                    'parametro_id' => $parametro->id,
                    'operacion' => 'multiplicación', // Ejemplo de operación
                    'estado' => true,
                ]);
            }
        }
    }
}
