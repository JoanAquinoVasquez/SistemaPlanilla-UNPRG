<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use App\Models\EmpleadoTipo;
use App\Models\Banco;
use Carbon\Carbon;

class PrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todos los tipos de empleados y bancos
        $empleadoTipos = EmpleadoTipo::all();
        $bancos = Banco::all();

        // Generar préstamos de ejemplo para cada empleado tipo
        foreach ($empleadoTipos as $empleadoTipo) {
            foreach ($bancos as $banco) {
                Prestamo::create([
                    'empleado_tipo_id' => $empleadoTipo->id,
                    'banco_id' => $banco->id,
                    'fecha_inicio' => Carbon::now()->subMonths(rand(1, 24)),
                    'fecha_fin' => Carbon::now()->addMonths(rand(1, 24)),
                    'monto_prestado' => rand(1000, 5000),
                    'monto_restante' => rand(500, 4500),
                    'numero_cuotas' => rand(6, 36),
                    'estado' => true,
                ]);
            }
        }
    }
}
