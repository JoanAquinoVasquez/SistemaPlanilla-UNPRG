<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubTipoEmpleado;
use App\Models\TipoEmpleado;

class SubTipoEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener IDs de tipo_empleados específicos
        $docenteId = TipoEmpleado::where('nombre', 'Docente')->first()->id;
        $administrativoId = TipoEmpleado::where('nombre', 'Administrativo')->first()->id;
        $practicanteId = TipoEmpleado::where('nombre', 'Practicante')->first()->id;

        // Subtipos específicos para cada tipo de empleado
        $subTipos = [
            // Subtipos de Docente
            [
                'nombre' => 'Nombrado',
                'descripcion' => 'Docente con plaza permanente.',
                'tipo_empleado_id' => $docenteId,
            ],
            [
                'nombre' => 'Contratado',
                'descripcion' => 'Docente con contrato temporal.',
                'tipo_empleado_id' => $docenteId,
            ],

            // Subtipos de Administrativo
            [
                'nombre' => 'Nombrado',
                'descripcion' => 'Administrativo con plaza permanente.',
                'tipo_empleado_id' => $administrativoId,
            ],
            [
                'nombre' => 'Contratado',
                'descripcion' => 'Administrativo con contrato temporal.',
                'tipo_empleado_id' => $administrativoId,
            ],
            [
                'nombre' => 'CAS',
                'descripcion' => 'Administrativo con contrato de servicios (CAS).',
                'tipo_empleado_id' => $administrativoId,
            ],

            // Subtipos de Practicante
            [
                'nombre' => 'Profesional',
                'descripcion' => 'Practicante con título profesional.',
                'tipo_empleado_id' => $practicanteId,
            ],
            [
                'nombre' => 'Preprofesional',
                'descripcion' => 'Practicante en formación profesional.',
                'tipo_empleado_id' => $practicanteId,
            ],
        ];

        // Insertar cada subtipo en la tabla sub_tipo_empleados
        foreach ($subTipos as $subTipo) {
            SubTipoEmpleado::create($subTipo);
        }
    }
}
