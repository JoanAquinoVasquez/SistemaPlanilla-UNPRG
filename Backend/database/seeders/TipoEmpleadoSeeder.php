<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoEmpleado;

class TipoEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Valores específicos para la tabla tipo_empleados
        $tipoEmpleados = [
            [
                'nombre' => 'Docente',
                'descripcion' => 'Encargado de impartir clases y gestionar el aprendizaje.',
            ],
            [
                'nombre' => 'Administrativo',
                'descripcion' => 'Responsable de tareas de apoyo y gestión en la administración.',
            ],
            [
                'nombre' => 'Practicante',
                'descripcion' => 'Colaborador en formación que asiste en diversas tareas.',
            ],
        ];

        // Inserta cada registro en la tabla tipo_empleados
        foreach ($tipoEmpleados as $tipoEmpleado) {
            TipoEmpleado::create($tipoEmpleado);
        }
    }
}
