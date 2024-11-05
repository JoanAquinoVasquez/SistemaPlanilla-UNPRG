<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documento>
 */
class DocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->sentence(3), // Genera un nombre aleatorio
            'tipo' => $this->faker->randomElement(['Certificado', 'Licencia', 'Informe', 'Permiso']),
            'fecha_vigencia' => $this->faker->date(),
            'fecha_fin' => $this->faker->optional()->date(), // Puede ser nulo
            'estado' => $this->faker->boolean(), // Genera true o false aleatoriamente
        ];
    }
}
