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
        // Obtener todos los empleados y áreas
        $empleadoTipos = EmpleadoTipo::all();
        $areas = Area::all();

        // Iterar por cada empleado_tipo
        foreach ($empleadoTipos as $empleadoTipo) {
            $isFirst = true; // Usado para asignar estado true solo al primer área

            foreach ($areas as $area) {
                // Crear el registro usando el modelo AreaEmpleadoTipo
                AreaEmpleadoTipo::create([
                    'empleado_tipo_id' => $empleadoTipo->id,
                    'area_id' => $area->id,
                    'estado' => $isFirst ? true : false, // Asigna true solo al primer área
                ]);
                
                // Después del primer área, establecer isFirst a false para que los siguientes sean estado false
                $isFirst = false;
            }
        }
    }
}
