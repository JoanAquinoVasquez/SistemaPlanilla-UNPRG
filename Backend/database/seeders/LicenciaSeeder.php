<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Licencia;
use App\Models\EmpleadoTipo;

class LicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($empleadoTipos as $empleadoTipo) {
            Licencia::create([
                'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                'estado' => true,
                'numero_dias' => fake()->numberBetween(1, 15), // Número de días de licencia
                'goze' => fake()->boolean(), // Indica si la licencia es con goce de haber
                'detalle' => fake()->optional()->sentence(), // Descripción opcional
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
