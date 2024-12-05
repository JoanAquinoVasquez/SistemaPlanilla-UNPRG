<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategoriaEmpleado;
use App\Models\CategoriaEmpleado;

class SubCategoriaEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Función para construir descripciones completas
        function buildDescription($categoriaId)
        {
            $categoria = CategoriaEmpleado::find($categoriaId);
            $subTipoEmpleado = $categoria->subTipoEmpleado;
            $tipoEmpleado = $subTipoEmpleado->tipoEmpleado;
            return "{$tipoEmpleado->nombre} {$subTipoEmpleado->nombre} {$categoria->nombre}";
        }

        // Definir subcategorías específicas para cada categoría de empleado
        $subCategorias = [];

        // Subcategorías para Docente Nombrado
        $docenteNombrado = [
            'Principal' => ['Dedicación Exclusiva', 'Tiempo Completo', 'Tiempo Parcial'],
            'Asociado' => ['Dedicación Exclusiva', 'Tiempo Completo', 'Tiempo Parcial'],
            'Auxiliar' => ['Tiempo Completo', 'Tiempo Parcial']
        ];

        foreach ($docenteNombrado as $categoria => $subcategorias) {
            $categoriaId = CategoriaEmpleado::where('nombre', $categoria)->first()?->id;
            if ($categoriaId) {
                foreach ($subcategorias as $sub) {
                    $subCategorias[] = [
                        'nombre' => $sub,
                        'descripcion' => buildDescription($categoriaId, $sub),
                        'categoria_empleado_id' => $categoriaId
                    ];
                }
            }
        }

        // Subcategorías para Docente Contratado categorías A1 a B3 con horas
        $docenteContratado = [
            'A1' => '32 Hrs',
            'A2' => '16 Hrs',
            'A3' => '8 Hrs',
            'B1' => '32 Hrs',
            'B2' => '16 Hrs',
            'B3' => '8 Hrs'
        ];

        foreach ($docenteContratado as $categoria => $horas) {
            $categoriaId = CategoriaEmpleado::where('nombre', $categoria)->first()?->id;
            if ($categoriaId) {
                $subCategorias[] = [
                    'nombre' => $horas,
                    'descripcion' => buildDescription($categoriaId, $horas),
                    'categoria_empleado_id' => $categoriaId
                ];
            }
        }

        // Definir subcategorías comunes para Administrativo en Nombrado, Contratado, y CAS
        $tiposAdministrativo = [
            'Funcionario' => ['F1', 'F2', 'F3', 'F4'],
            'Profesional' => ['SPA', 'SPB', 'SPC', 'SPD', 'SPE'],
            'Técnico' => ['STA', 'STB', 'STC', 'STD', 'STE'],
            'Auxiliar' => ['SAA', 'SAB', 'SAC', 'SAD', 'SAE']
        ];

        $tiposContratacion = ['Nombrado', 'Contratado', 'CAS'];

        foreach ($tiposContratacion as $tipoContratacion) {
            foreach ($tiposAdministrativo as $categoria => $niveles) {
                $categoriaId = CategoriaEmpleado::where('nombre', $categoria)
                    ->whereHas('subTipoEmpleado', function ($query) use ($tipoContratacion) {
                        $query->whereHas('tipoEmpleado', function ($query) {
                            $query->where('nombre', 'Administrativo');
                        })->where('nombre', $tipoContratacion);
                    })->first()?->id;

                if ($categoriaId) {
                    foreach ($niveles as $nivel) {
                        $subCategorias[] = [
                            'nombre' => $nivel,
                            'descripcion' => buildDescription($categoriaId, $nivel),
                            'categoria_empleado_id' => $categoriaId
                        ];
                    }
                }
            }
        }

        // Insertar subcategorías en la tabla sub_categoria_empleados
        foreach ($subCategorias as $subCategoria) {
            SubCategoriaEmpleado::create($subCategoria);
        }
    }
}
