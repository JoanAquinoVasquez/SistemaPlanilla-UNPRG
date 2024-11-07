<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aportacion;
use App\Models\FormulaParametro;

class AportacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $formulaParametros = FormulaParametro::all(); // Verifica la existencia de registros en 'formula_parametros'

        $aportaciones = [
            [
                'concepto' => 'Aporte a AFP',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Aporte a ONP',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Seguro de Salud',
                'sujeto_ley' => true,
            ],
            [
                'concepto' => 'Fondo de Pensión Voluntario',
                'sujeto_ley' => false,
            ],
            [
                'concepto' => 'Fondo Mutual',
                'sujeto_ley' => false,
            ],
        ];

        foreach ($aportaciones as $aportacionData) {
            // Seleccionar un `formula_parametro_id` aleatorio para cada registro
            $aportacionData['formula_parametro_id'] = $formulaParametros->random()->id;
            Aportacion::create($aportacionData);
        }
    }
}
