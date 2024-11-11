<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\EmpleadoTipo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel(){
        $empleadoTipos = EmpleadoTipo::with(['empleado', 'banco', ])
        ->where('id_tipo_empleado', 1) //id_tipo_empleado = 1 hace referencia al EmpleadoTipo: Practicante
        //->where('estado', 1) 
        ->get();
        
        
        //return $empleadoTipos;
        return Excel::download(new ReporteExport($empleadoTipos), 'reportePracticante.xlsx');
    }
}
