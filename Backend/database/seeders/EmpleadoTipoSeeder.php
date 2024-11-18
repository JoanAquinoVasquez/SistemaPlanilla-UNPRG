<?php

namespace Database\Seeders;

use App\Models\Aportacion;
use Illuminate\Database\Seeder;
use App\Models\EmpleadoTipo;
use App\Models\TipoEmpleado;
use App\Models\Empleado;
use App\Models\Banco;
use App\Models\CategoriaEmpleado;
use App\Models\SubCategoriaEmpleado;
use App\Models\SubTipoEmpleado;

class EmpleadoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleados = Empleado::all();
        $bancos = Banco::all();
        $tiposEmpleado = TipoEmpleado::all();
        $subTiposEmpleado = SubTipoEmpleado::all();
        $categoriasEmpleado = CategoriaEmpleado::all();
        $subCategoriasEmpleado = SubCategoriaEmpleado::all();

        foreach ($empleados as $empleado) {
            foreach ($tiposEmpleado as $tipo) {
                // Obtener un subTipo relacionado con el tipo actual si existe
                $subTipo = $subTiposEmpleado->where('tipo_empleado_id', $tipo->id)->isNotEmpty() ? $subTiposEmpleado->where('tipo_empleado_id', $tipo->id)->random() : null;

                // Obtener una categoria relacionada con el subTipo actual si existe
                $categoria = $subTipo && $categoriasEmpleado->where('sub_tipo_empleado_id', $subTipo->id)->isNotEmpty() ? $categoriasEmpleado->where('sub_tipo_empleado_id', $subTipo->id)->random() : null;

                // Obtener una subCategoria relacionada con la categoria actual si existe
                $subCategoria = $categoria && $subCategoriasEmpleado->where('categoria_empleado_id', $categoria->id)->isNotEmpty() ? $subCategoriasEmpleado->where('categoria_empleado_id', $categoria->id)->random() : null;

                EmpleadoTipo::create([
                    'empleado_num_doc_iden' => $empleado->num_doc_iden,
                    'tipo_empleado_id' => $tipo->id,
                    'sub_tipo_empleado_id' => $subTipo ? $subTipo->id : null,
                    'categoria_empleado_id' => $categoria ? $categoria->id : null,
                    'sub_categoria_empleado_id' => $subCategoria ? $subCategoria->id : null,
                    'banco_id' => $bancos->random()->id,
                    'tipo_cuenta' => collect(['ahorros', 'corriente', 'plazo_fijo', 'sueldo', 'cts'])->random(),
                    'cci' => fake()->numerify('#############'),
                    'numero_cuenta' => fake()->numerify('############'),
                    'estado' => collect([0, 1])->random()
                ]);
            }
        }
    }
}
