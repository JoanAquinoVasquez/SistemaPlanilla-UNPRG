<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $areas = [
            [
                'nombre' => 'Organo de Control Institucional',
                'oficina' => 'OCII',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Asesoria Juridica',
                'oficina' => 'OAJ',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Planeamiento y Presupuesto',
                'oficina' => 'OPP',
                'unidad' => 'UPP',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Modernización',
                'oficina' => 'UM',
                'unidad' => 'UPP',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad Formuladora',
                'oficina' => 'UF',
                'unidad' => 'UPP',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Gestión de la Calidad',
                'oficina' => 'OGC',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Cooperación y Relaciones Internacionales',
                'oficina' => 'OCRI',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Comunicación e Imagen Institucional',
                'oficina' => 'OCII',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Dirección General de Administración',
                'oficina' => 'DGA',
                'unidad' => 'URH',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Contabilidad',
                'oficina' => 'UC',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Tesorería',
                'oficina' => 'UT',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Abastecimiento',
                'oficina' => 'UA',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Recursos Humanos',
                'oficina' => 'URH',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad Ejecutora de Inversiones',
                'oficina' => 'UEI',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Unidad de Servicios Generales',
                'oficina' => 'USG',
                'unidad' => 'DGA',
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Oficina de Tecnologías de la Información',
                'oficina' => 'OTI',
                'unidad' => null,
                'facultad' => null,
                'escuela' => null,
                'estado' => true,
            ],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
