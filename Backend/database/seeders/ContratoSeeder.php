<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrato;
use App\Models\EmpleadoTipo;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($empleadoTipos as $empleadoTipo) {
            Contrato::create([
                'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                'sueldo_bruto' => fake()->randomFloat(2, 1500, 5000),
                'fecha_inicio' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'fecha_fin' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'estado' => fake()->boolean(90), // 90% de probabilidad de estar activo
                'tipo_documento' => fake()->randomElement(['Contrato', 'Acuerdo', 'Convenio']),
                'numero_documento' => fake()->unique()->numerify('DOC########'),
                'regimen_laboral' => fake()->randomElement(['Tiempo Completo', 'Medio Tiempo', 'Parcial']),
                'horas_trabajo' => fake()->numberBetween(20, 40),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
