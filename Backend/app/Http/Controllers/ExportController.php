<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\EmpleadoTipo;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel()
    {
        $empleadoTipos = EmpleadoTipo::with([
            'banco',
            'empleado',
            'tipoEmpleado',
            'subTipoEmpleado',
            'categoriaEmpleado',
            'subCategoriaEmpleado',
            'areaActiva.area',
            'aportacionPension'
        ])
            ->where('tipo_empleado_id', 3)
            ->get();

        //return $empleadoTipos;
        //return $empleadoTipos;
        return Excel::download(new ReporteExport($empleadoTipos), 'reportePracticante.xlsx');
    }
}
