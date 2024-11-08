<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmpleadoTipo;
use App\Models\TipoEmpleado;
use App\Models\Empleado;
use App\Models\Banco;

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

        foreach ($empleados as $empleado) {
            foreach ($tiposEmpleado as $tipo) {
                EmpleadoTipo::create([
                    'id_tipo_empleado' => $tipo->id,
                    'num_doc_iden' => $empleado->num_doc_iden,
                    'banco_id' => $bancos->random()->id,
                    'tipo_cuenta' => collect(['ahorros', 'corriente', 'plazo_fijo', 'sueldo', 'cts'])->random(),
                    'cci' => fake()->numerify('#############'),
                    'numero_cuenta' => fake()->numerify('############'),
                    'estado' => collect([0,1])->random()
                ]);
            }
        }
    }
}
