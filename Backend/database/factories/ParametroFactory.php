<?php

namespace Database\Factories;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parametro>
 */
class ParametroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->word,
            'valor' => $this->faker->randomFloat(2, 0, 9999999), // Máximo de 9999999.99
            'documento_id' => Documento::factory(), // Crear o asignar un documento
            'estado' => $this->faker->boolean(), // Genera true o false aleatoriamente
        ];
    }
}
