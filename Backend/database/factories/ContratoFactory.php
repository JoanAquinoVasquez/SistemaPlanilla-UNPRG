<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EmpleadoTipo;

class ContratoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'empleado_tipo_id' => EmpleadoTipo::inRandomOrder()->first()->id_tipo_empleado,
            'empleado_tipo_num_doc_iden' => EmpleadoTipo::inRandomOrder()->first()->num_doc_iden,
            'sueldo_bruto' => $this->faker->randomFloat(2, 1500, 5000),
            'fecha_inicio' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'fecha_fin' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'estado' => $this->faker->boolean(90),
            'tipo_documento' => $this->faker->randomElement(['Contrato', 'Acuerdo', 'Convenio']),
            'numero_documento' => $this->faker->unique()->numerify('DOC########'),
            'regimen_laboral' => $this->faker->randomElement(['Tiempo Completo', 'Medio Tiempo', 'Parcial']),
            'horas_trabajo' => $this->faker->numberBetween(20, 40),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
