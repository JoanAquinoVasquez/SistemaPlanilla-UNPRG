<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Parentesco;
use App\Models\Empleado;

class DetalleFamiliaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'tipo_doc' => $this->faker->randomElement(['DNI', 'Pasaporte', 'Carnet de Extranjería']),
            'num_doc' => $this->faker->unique()->numerify('###########'),
            'nombres' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'telefono' => $this->faker->numerify('9########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'),
            'nivel_escolaridad' => $this->faker->randomElement(['Primaria', 'Secundaria', 'Técnico', 'Universitario']),
            'dependiente' => $this->faker->boolean,
            'discapacidad' => $this->faker->boolean(10), // 10% de probabilidad de discapacidad
            'estado' => $this->faker->boolean(80), // 80% de probabilidad de activo
            'empleado_num_doc_iden' => Empleado::inRandomOrder()->first()->num_doc_iden,
            'parentesco_id' => Parentesco::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
