<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleIngreso;
use App\Models\Remuneracion;
use App\Models\EmpleadoTipo;
use App\Models\Ingreso;
use Carbon\Carbon;

class DetalleIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todas las aportaciones, remuneraciones y tipos de empleados
        $ingresos = Ingreso::all();
        $remuneraciones = Remuneracion::all();
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($ingresos as $ingreso) {
            foreach ($remuneraciones as $remuneracion) {
                foreach ($empleadoTipos as $empleadoTipo) {
                    DetalleIngreso::create([
                        'ingreso_id' => $ingreso->id,
                        'remuneracion_id' => $remuneracion->id,
                        'empleado_tipo_id' => $empleadoTipo->id,
                        'monto' => rand(10, 50),
                        'fecha_inicio' => Carbon::now()->subMonth()->startOfMonth(),
                        'fecha_fin' => Carbon::now()->subMonth()->endOfMonth(),
                        //'monto' => rand(100, 1000), // Valor aleatorio para simular el monto de ingreso
                    ]);
                }
            }
        }
    }
}
