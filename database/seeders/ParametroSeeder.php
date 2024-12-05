<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametro;
use App\Models\Documento;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buscar documentos específicos por nombre o tipo para asociar con cada parámetro
        $documentoAfp = Documento::where('nombre', 'Ley de Reforma del Sistema Privado de Pensiones')->first()->id;
        $documentoEssalud = Documento::where('nombre', 'Reglamento del Seguro Social en Salud')->first()->id;
        $documentoBonificacionFamiliar = Documento::where('nombre', 'Reglamento de Bonificación Familiar')->first()->id;
        $documentoCts = Documento::where('nombre', 'Decreto Supremo de Compensación por Tiempo de Servicios')->first()->id;
        $documentoGratificacion = Documento::where('nombre', 'Ley de Gratificaciones de Julio y Diciembre')->first()->id;
        $documentoSeguroVida = Documento::where('nombre', 'Reglamento del Seguro Vida Ley')->first()->id;

        $parametros = [
            [
                'nombre' => 'Tasa de Descuento AFP',
                'valor' => 10.00,
                'documento_id' => $documentoAfp,
                'estado' => true,
            ],
            [
                'nombre' => 'Aporte ESSALUD',
                'valor' => 9.00,
                'documento_id' => $documentoEssalud,
                'estado' => true,
            ],
            [
                'nombre' => 'Bonificación Familiar',
                'valor' => 93.00,
                'documento_id' => $documentoBonificacionFamiliar,
                'estado' => true,
            ],
            [
                'nombre' => 'Porcentaje CTS',
                'valor' => 8.33,
                'documento_id' => $documentoCts,
                'estado' => true,
            ],
            [
                'nombre' => 'Gratificación Julio/Diciembre',
                'valor' => 100.00,
                'documento_id' => $documentoGratificacion,
                'estado' => true,
            ],
            [
                'nombre' => 'Seguro Vida Ley',
                'valor' => 0.53,
                'documento_id' => $documentoSeguroVida,
                'estado' => true,
            ],
        ];

        foreach ($parametros as $parametro) {
            Parametro::create($parametro);
        }
    }
}
