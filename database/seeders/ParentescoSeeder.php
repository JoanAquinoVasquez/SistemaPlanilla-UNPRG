<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parentesco;

class ParentescoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $gradosParentesco = [
            // Consanguinidad
            ['nombre' => 'Padre', 'tipo' => 'consanguinidad', 'nivel' => 'primer grado'],
            ['nombre' => 'Madre', 'tipo' => 'consanguinidad', 'nivel' => 'primer grado'],
            ['nombre' => 'Hijo/a', 'tipo' => 'consanguinidad', 'nivel' => 'primer grado'],
            ['nombre' => 'Hermano/a', 'tipo' => 'consanguinidad', 'nivel' => 'segundo grado'],
            ['nombre' => 'Abuelo/a', 'tipo' => 'consanguinidad', 'nivel' => 'segundo grado'],
            ['nombre' => 'Nieto/a', 'tipo' => 'consanguinidad', 'nivel' => 'segundo grado'],
            ['nombre' => 'Tío/a', 'tipo' => 'consanguinidad', 'nivel' => 'tercer grado'],
            ['nombre' => 'Sobrino/a', 'tipo' => 'consanguinidad', 'nivel' => 'tercer grado'],
            ['nombre' => 'Primo/a', 'tipo' => 'consanguinidad', 'nivel' => 'cuarto grado'],

            // Afinidad
            ['nombre' => 'Esposo/a', 'tipo' => 'afinidad', 'nivel' => 'primer grado'],
            ['nombre' => 'Hijastro/a', 'tipo' => 'afinidad', 'nivel' => 'primer grado'],
            ['nombre' => 'Suegro/a', 'tipo' => 'afinidad', 'nivel' => 'segundo grado'],
            ['nombre' => 'Cuñado/a', 'tipo' => 'afinidad', 'nivel' => 'segundo grado']
        ];

        foreach ($gradosParentesco as $grado) {
            Parentesco::create($grado);
        }
    }
}
