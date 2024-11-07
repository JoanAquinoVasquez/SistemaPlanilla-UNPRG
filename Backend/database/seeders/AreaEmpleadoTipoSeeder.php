<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaEmpleadoTipo;
use App\Models\EmpleadoTipo;
use App\Models\Area;

class AreaEmpleadoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $areas = Area::all();
        $empleadoTipos = EmpleadoTipo::all();

        foreach ($empleadoTipos as $empleadoTipo) {
            foreach ($areas->random(5) as $area) {
                AreaEmpleadoTipo::create([
                    'empleado_tipo_id' => $empleadoTipo->id_tipo_empleado,
                    'empleado_tipo_num_doc_iden' => $empleadoTipo->num_doc_iden,
                    'area_id' => $area->id,
                    'estado' => true,
                ]);
            }
        }
    }
}
