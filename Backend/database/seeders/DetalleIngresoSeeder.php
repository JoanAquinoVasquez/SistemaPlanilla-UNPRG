<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleIngreso;
use App\Models\Aportacion;
use App\Models\Remuneracion;
use App\Models\EmpleadoTipo;

class DetalleIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todas las aportaciones, remuneraciones y tipos de empleados
        $aportaciones = Aportacion::all();
        $remuneraciones = Remuneracion::all();
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($aportaciones as $aportacion) {
            foreach ($remuneraciones as $remuneracion) {
                foreach ($empleadoTipos as $empleadoTipo) {
                    DetalleIngreso::create([
                        'aportacions_id' => $aportacion->id,
                        'remuneracion_id' => $remuneracion->id,
                        'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                        'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                        'monto' => rand(10, 100),
                        //'monto' => rand(100, 1000), // Valor aleatorio para simular el monto de ingreso
                    ]);
                }
            }
        }
    }
}
