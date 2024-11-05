<?php

namespace Database\Factories;

use App\Models\FormulaParametro;
use App\Models\Formula;
use App\Models\Parametro;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormulaParametroFactory extends Factory
{
    protected $model = FormulaParametro::class;

    public function definition()
    {
        return [
            'formula_id' => Formula::factory(), // Generar o asignar un Formula
            'parametro_id' => Parametro::factory(), // Generar o asignar un Parametro
            'operacion' => $this->faker->randomElement(['+', '-', '*', '/']), // Selecciona una operación aleatoria
            'estado' => $this->faker->boolean(), // Genera true o false aleatoriamente
        ];
    }
}
