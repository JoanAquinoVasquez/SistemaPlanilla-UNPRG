<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacacion;
use App\Models\EmpleadoTipo;

class VacacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($empleadoTipos as $empleadoTipo) {
            Vacacion::create([
                'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                'estado' => true,
                'numero_dias' => fake()->numberBetween(5, 30), // Número de días de vacaciones
               'periodo' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-01-01'), // Fecha establecida al 1 de enero del año seleccionado
                'detalle' => fake()->optional()->sentence(), // Descripción opcional
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
