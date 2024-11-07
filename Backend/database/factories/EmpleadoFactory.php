<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmpleadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \App\Models\Empleado::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'num_doc_iden' => $this->faker->unique()->numerify('###########'), // Número de documento
            'nombres' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'tipo_doc_iden' => $this->faker->randomElement(['DNI', 'Pasaporte', 'Carnet de Extranjería']),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'), // Fecha de nacimiento hasta 2000
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            'estado_civil' => $this->faker->randomElement(['Soltero', 'Casado', 'Viudo', 'Divorciado']),
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->numerify('9########'), // Número de teléfono peruano
            'email' => $this->faker->unique()->safeEmail,
            'estado' => $this->faker->boolean(80), // 80% de probabilidad de estar activo
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
