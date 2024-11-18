<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleAportacion;
use App\Models\Aportacion;
use App\Models\Remuneracion;
use App\Models\EmpleadoTipo;
use Carbon\Carbon;

class DetalleAportacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $aportaciones = Aportacion::all(); // Obtener todas las aportaciones
        $remuneraciones = Remuneracion::with('planilla')->get(); // Obtener todas las remuneraciones
        $empleadoTipos = EmpleadoTipo::all(); // Obtener todos los tipos de empleados

        foreach ($aportaciones as $aportacion) {
            foreach ($remuneraciones as $remuneracion) {
                DetalleAportacion::create([
                    'aportacions_id' => $aportacion->id,
                    'remuneracion_id' => $remuneracion->id,
                    'empleado_tipo_id' => $remuneracion->empleado_tipo_id,
                    'monto' => rand(10, 50),
                    'fecha_inicio' => $remuneracion->planilla->fecha_inicio,
                    'fecha_fin' => $remuneracion->planilla->fecha_fin,
                    /* 'monto' => rand(50, 500), */ // Valor aleatorio para el monto de la aportación
                ]);
            }
        }
    }
}
