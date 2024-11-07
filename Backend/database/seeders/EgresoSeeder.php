<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Egreso;
use App\Models\FormulaParametro;

class EgresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $formulaParametros = FormulaParametro::all(); // Asegura que existen registros en 'formula_parametros'

        $egresos = [
            [
                'concepto' => 'Descuento por AFP',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Descuento por ONP',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Seguro de Salud',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Préstamo Personal',
                'sujeto_ley' => false,
            ],
            [
                'concepto' => 'Descuento de Tardanzas',
                'sujeto_ley' => false,
            ],
        ];

        foreach ($egresos as $egresoData) {
            // Seleccionar un `formula_parametro_id` aleatorio para cada registro
            $egresoData['formula_parametro_id'] = $formulaParametros->random()->id;
            Egreso::create($egresoData);
        }
    }
}
