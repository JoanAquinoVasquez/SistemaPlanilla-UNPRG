<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaEmpleado;
use App\Models\SubTipoEmpleado;

class CategoriaEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener IDs de subtipos específicos de empleados
        $docenteNombradoId = SubTipoEmpleado::where('nombre', 'Nombrado')->whereHas('tipoEmpleado', function($query) {
            $query->where('nombre', 'Docente');
        })->first()->id;

        $docenteContratadoId = SubTipoEmpleado::where('nombre', 'Contratado')->whereHas('tipoEmpleado', function($query) {
            $query->where('nombre', 'Docente');
        })->first()->id;

        $administrativoNombradoId = SubTipoEmpleado::where('nombre', 'Nombrado')->whereHas('tipoEmpleado', function($query) {
            $query->where('nombre', 'Administrativo');
        })->first()->id;

        $administrativoContratadoId = SubTipoEmpleado::where('nombre', 'Contratado')->whereHas('tipoEmpleado', function($query) {
            $query->where('nombre', 'Administrativo');
        })->first()->id;

        $administrativoCasId = SubTipoEmpleado::where('nombre', 'CAS')->whereHas('tipoEmpleado', function($query) {
            $query->where('nombre', 'Administrativo');
        })->first()->id;

        // Definir categorías específicas para cada subtipo de empleado
        $categorias = [
            // Categorías para Docente Nombrado
            ['nombre' => 'Principal', 'descripcion' => 'Docente de mayor rango', 'sub_tipo_empleado_id' => $docenteNombradoId],
            ['nombre' => 'Asociado', 'descripcion' => 'Docente asociado', 'sub_tipo_empleado_id' => $docenteNombradoId],
            ['nombre' => 'Auxiliar', 'descripcion' => 'Docente auxiliar', 'sub_tipo_empleado_id' => $docenteNombradoId],

            // Categorías para Docente Contratado
            ['nombre' => 'A1', 'descripcion' => 'Docente contratado categoría A1', 'sub_tipo_empleado_id' => $docenteContratadoId],
            ['nombre' => 'A2', 'descripcion' => 'Docente contratado categoría A2', 'sub_tipo_empleado_id' => $docenteContratadoId],
            ['nombre' => 'A3', 'descripcion' => 'Docente contratado categoría A3', 'sub_tipo_empleado_id' => $docenteContratadoId],
            ['nombre' => 'B1', 'descripcion' => 'Docente contratado categoría B1', 'sub_tipo_empleado_id' => $docenteContratadoId],
            ['nombre' => 'B2', 'descripcion' => 'Docente contratado categoría B2', 'sub_tipo_empleado_id' => $docenteContratadoId],
            ['nombre' => 'B3', 'descripcion' => 'Docente contratado categoría B3', 'sub_tipo_empleado_id' => $docenteContratadoId],

            // Categorías para Administrativo Nombrado
            ['nombre' => 'Funcionario', 'descripcion' => 'Funcionario administrativo', 'sub_tipo_empleado_id' => $administrativoNombradoId],
            ['nombre' => 'Profesional', 'descripcion' => 'Personal profesional administrativo', 'sub_tipo_empleado_id' => $administrativoNombradoId],
            ['nombre' => 'Técnico', 'descripcion' => 'Personal técnico administrativo', 'sub_tipo_empleado_id' => $administrativoNombradoId],
            ['nombre' => 'Auxiliar', 'descripcion' => 'Personal auxiliar administrativo', 'sub_tipo_empleado_id' => $administrativoNombradoId],

            // Categorías para Administrativo Contratado
            ['nombre' => 'Funcionario', 'descripcion' => 'Funcionario administrativo contratado', 'sub_tipo_empleado_id' => $administrativoContratadoId],
            ['nombre' => 'Profesional', 'descripcion' => 'Personal profesional administrativo contratado', 'sub_tipo_empleado_id' => $administrativoContratadoId],
            ['nombre' => 'Técnico', 'descripcion' => 'Personal técnico administrativo contratado', 'sub_tipo_empleado_id' => $administrativoContratadoId],
            ['nombre' => 'Auxiliar', 'descripcion' => 'Personal auxiliar administrativo contratado', 'sub_tipo_empleado_id' => $administrativoContratadoId],

            // Categorías para Administrativo CAS
            ['nombre' => 'Funcionario', 'descripcion' => 'Funcionario administrativo CAS', 'sub_tipo_empleado_id' => $administrativoCasId],
            ['nombre' => 'Profesional', 'descripcion' => 'Personal profesional administrativo CAS', 'sub_tipo_empleado_id' => $administrativoCasId],
            ['nombre' => 'Técnico', 'descripcion' => 'Personal técnico administrativo CAS', 'sub_tipo_empleado_id' => $administrativoCasId],
            ['nombre' => 'Auxiliar', 'descripcion' => 'Personal auxiliar administrativo CAS', 'sub_tipo_empleado_id' => $administrativoCasId],
        ];

        // Insertar categorías en la tabla categoria_empleados
        foreach ($categorias as $categoria) {
            CategoriaEmpleado::create($categoria);
        }
    }
}
