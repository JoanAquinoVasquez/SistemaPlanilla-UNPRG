<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlAsistencia;
use App\Models\EmpleadoTipo;

class ControlAsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($empleadoTipos as $empleadoTipo) {
            ControlAsistencia::create([
                'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                'numero_asistencias' => fake()->numberBetween(15, 30), // Ejemplo: de 15 a 30 días
                'numero_inasistencias' => fake()->numberBetween(0, 5),
                'numero_tardanzas' => fake()->numberBetween(0, 10),
                'periodo' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'numero_permisos' => fake()->numberBetween(0, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
