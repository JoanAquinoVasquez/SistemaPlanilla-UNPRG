<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleAportacion;
use App\Models\Aportacion;
use App\Models\Remuneracion;
use App\Models\EmpleadoTipo;

class DetalleAportacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $aportaciones = Aportacion::all(); // Obtener todas las aportaciones
        $remuneraciones = Remuneracion::all(); // Obtener todas las remuneraciones
        $empleadoTipos = EmpleadoTipo::all(); // Obtener todos los tipos de empleados

        foreach ($aportaciones as $aportacion) {
            foreach ($remuneraciones as $remuneracion) {
                foreach ($empleadoTipos as $empleadoTipo) {
                    DetalleAportacion::create([
                        'aportacions_id' => $aportacion->id,
                        'remuneracion_id' => $remuneracion->id,
                        'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                        'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                        'monto' => rand(50, 500), // Valor aleatorio para el monto de la aportación
                    ]);
                }
            }
        }
    }
}
