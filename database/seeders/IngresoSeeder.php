<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingreso;
use App\Models\FormulaParametro;

class IngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $formulaParametros = FormulaParametro::all(); // Asegura que existen registros en 'formula_parametros'

        $ingresos = [
            [
                'concepto' => 'Sueldo Básico',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Bonificación Familiar',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Horas Extras',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Gratificación',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Reembolso de Gastos',
                'sujeto_ley' => false,
            ],
        ];

        foreach ($ingresos as $ingresoData) {
            // Seleccionar un `formula_parametro_id` aleatorio para cada registro
            $ingresoData['formula_parametro_id'] = $formulaParametros->random()->id;
            Ingreso::create($ingresoData);
        }
    }
}
