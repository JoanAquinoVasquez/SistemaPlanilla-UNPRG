<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formula;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $formulas = [
            [
                'nombre' => 'Cálculo de Sueldo Neto',
                'descripcion' => 'Fórmula para calcular el sueldo neto del empleado después de los descuentos aplicados.',
                'estado' => true,
            ],
            [
                'nombre' => 'Descuento AFP',
                'descripcion' => 'Calcula el descuento del AFP (Administradora de Fondos de Pensiones) sobre el sueldo bruto.',
                'estado' => true,
            ],
            [
                'nombre' => 'Descuento ESSALUD',
                'descripcion' => 'Fórmula para calcular el descuento correspondiente a ESSALUD.',
                'estado' => true,
            ],
            [
                'nombre' => 'Bonificación Familiar',
                'descripcion' => 'Calcula la bonificación familiar para empleados que califican según las normas vigentes.',
                'estado' => true,
            ],
            [
                'nombre' => 'Gratificación Semestral',
                'descripcion' => 'Fórmula para calcular la gratificación otorgada dos veces al año.',
                'estado' => true,
            ],
            [
                'nombre' => 'Compensación por Tiempo de Servicios (CTS)',
                'descripcion' => 'Cálculo de la CTS, que corresponde al pago de beneficios por tiempo de servicio.',
                'estado' => true,
            ],
        ];

        foreach ($formulas as $formula) {
            Formula::create($formula);
        }
    }
}
