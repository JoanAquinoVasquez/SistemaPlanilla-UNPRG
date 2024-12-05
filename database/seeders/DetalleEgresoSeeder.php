<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleEgreso;
use App\Models\Egreso;
use App\Models\Remuneracion;
use App\Models\EmpleadoTipo;
use Carbon\Carbon;

class DetalleEgresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todas las aportaciones, remuneraciones y tipos de empleados
        $egresos = Egreso::all();
        $remuneraciones = Remuneracion::with('planilla')->get();
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($egresos as $egreso) {
            foreach ($remuneraciones as $remuneracion) {
                DetalleEgreso::create([
                    'egreso_id' => $egreso->id,
                    'remuneracion_id' => $remuneracion->id,
                    'empleado_tipo_id' => $remuneracion->empleado_tipo_id,
                    'monto' => rand(10, 50),
                    'fecha_inicio' => $remuneracion->planilla->fecha_inicio,
                    'fecha_fin' => $remuneracion->planilla->fecha_fin,
                    /* 'monto' => rand(50, 500), */ // Valor aleatorio para el monto del egreso
                ]);
            }
        }
    }
}
