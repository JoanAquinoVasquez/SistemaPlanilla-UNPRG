<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documento;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $documentos = [
            [
                'nombre' => 'Ley de Reforma del Sistema Privado de Pensiones',
                'tipo' => 'Ley',
                'fecha_vigencia' => '2013-01-01',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Reglamento del Seguro Social en Salud',
                'tipo' => 'Reglamento',
                'fecha_vigencia' => '2005-04-12',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Decreto Supremo de Compensación por Tiempo de Servicios',
                'tipo' => 'Decreto',
                'fecha_vigencia' => '1997-05-28',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Ley de Gratificaciones de Julio y Diciembre',
                'tipo' => 'Ley',
                'fecha_vigencia' => '2008-07-15',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Reglamento de Bonificación Familiar',
                'tipo' => 'Reglamento',
                'fecha_vigencia' => '2001-06-30',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Reglamento del Seguro Vida Ley',
                'tipo' => 'Reglamento',
                'fecha_vigencia' => '2000-01-01',
                'fecha_fin' => null,
                'estado' => true,
            ],
            [
                'nombre' => 'Ley de Gratificaciones de Julio y Diciembre',
                'tipo' => 'Ley',
                'fecha_vigencia' => '2005-06-30',
                'fecha_fin' => null,
                'estado' => true,
            ],
        ];

        foreach ($documentos as $documento) {
            Documento::create($documento);
        }
    }
}
