<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Remuneracion;
use App\Models\Planilla;
use App\Models\EmpleadoTipo;

class RemuneracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $planillas = Planilla::all(); // Obtener todas las planillas
        $empleadoTipos = EmpleadoTipo::all(); // Obtener todos los tipos de empleados

        foreach ($planillas as $planilla) {
            foreach ($empleadoTipos as $empleadoTipo) {
                Remuneracion::create([
                    'planilla_id' => $planilla->id,
                    'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                    'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                    'sueldo_bruto' => rand(1000, 5000), // Ejemplo de valor aleatorio de sueldo bruto
                    'total_ingreso' => rand(2000, 6000), // Ejemplo de valor aleatorio de ingreso total
                    'total_egreso' => rand(500, 1500), // Ejemplo de valor aleatorio de egreso total
                    'sueldo_aporte' => rand(100, 500), // Ejemplo de valor aleatorio de sueldo de aporte
                    'sueldo_neto' => rand(1500, 4500), // Ejemplo de valor aleatorio de sueldo neto
                ]);
            }
        }
    }
}
