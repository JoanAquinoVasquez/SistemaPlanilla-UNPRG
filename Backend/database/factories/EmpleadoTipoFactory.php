<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empleado;
use App\Models\TipoEmpleado;
use App\Models\Banco;

class EmpleadoTipoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'id_tipo_empleado' => TipoEmpleado::inRandomOrder()->first()->id,
            'num_doc_iden' => Empleado::inRandomOrder()->first()->num_doc_iden,
            'banco_id' => Banco::inRandomOrder()->first()->id,
            'tipo_cuenta' => $this->faker->randomElement(['ahorros', 'corriente', 'plazo_fijo', 'sueldo', 'cts']),
            'cci' => $this->faker->numerify('#############'),
            'numero_cuenta' => $this->faker->numerify('############'),
            'estado' => $this->faker->randomElement([0,1]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
