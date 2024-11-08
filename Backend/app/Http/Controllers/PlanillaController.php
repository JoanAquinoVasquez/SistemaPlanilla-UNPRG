<?php

namespace App\Http\Controllers;

use App\Models\Aportacion;
use App\Models\DetalleAportacion;
use App\Models\DetalleEgreso;
use App\Models\DetalleIngreso;
use App\Models\Empleado;
use App\Models\EmpleadoTipo;
use App\Models\Planilla;
use App\Models\Remuneracion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanillaController extends Controller
{

    public function generarPlanilla()
    {
        try {
            // Definir el periodo de la planilla (puedes cambiar estas fechas según sea necesario)
            $fechaInicio = '2024-10-01';
            $fechaFin = '2024-10-31';

            // Verificar si ya existe una planilla para el periodo especificado
            /* $planillaExistente = DB::table('planillas')
                ->where('fecha_inicio', $fechaInicio)
                ->where('fecha_fin', $fechaFin)
                ->first(); */

            // Si ya existe una planilla para este periodo, usarla
            //if ($planillaExistente) {
            //    $idPlanilla = $planillaExistente->id;
            //} else {
            // Si no existe, crear una nueva planilla
            $planilla = Planilla::create([
                'user_id' => 1,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'fecha_generacion' => now(),
                'estado' => 1
            ]);
            //}

            // Obtener todos los tipos de empleados junto con sus datos de empleados relacionados
            $empleadoTipos = EmpleadoTipo::where('estado', 1)
                ->with(['empleado', 'tipoEmpleado'])
                ->get();

            // Verificar si hay empleados disponibles
            if ($empleadoTipos->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontraron empleados activos',
                ], 404);
            }

            $planillas = [];

            foreach ($empleadoTipos as $empleadoTipo) {
                try {
                    // Verificar si existe la remuneración para el empleado actual
                    $remuneracion = Remuneracion::where('empleado_tipo_num_doc_iden', $empleadoTipo->num_doc_iden)
                        ->first();

                    if (!$remuneracion) {
                        throw new \Exception("No se encontró remuneración para el empleado con DNI: {$empleadoTipo->num_doc_iden}");
                    }

                    $sueldobruto = $remuneracion->sueldo_bruto ?? 0;

                    // Calcular los egresos (descuentos)
                    $egresos = DetalleEgreso::where('empleado_tipo_num_doc_iden', $empleadoTipo->num_doc_iden)
                        ->sum('monto');

                    // Calcular los aportes
                    $aportes = DetalleAportacion::where('empleado_tipo_num_doc_iden', $empleadoTipo->num_doc_iden)
                        ->sum('monto');

                    // Calcular los ingresos adicionales
                    $ingresos = DetalleIngreso::where('empleado_tipo_num_doc_iden', $empleadoTipo->num_doc_iden)
                        ->sum('monto');

                    // Calcular el sueldo neto
                    $sueldo_neto = $sueldobruto + $ingresos - $egresos;

                    // Agregar el resultado al array de planillas
                    $planillas[] = [
                        'id_planilla' => $planilla->id,
                        'empleado' => [
                            'num_doc_iden' => $empleadoTipo->num_doc_iden,
                            'nombres' => $empleadoTipo->empleado->nombres,
                            'apellido_paterno' => $empleadoTipo->empleado->apellido_paterno,
                            'apellido_materno' => $empleadoTipo->empleado->apellido_materno,
                        ],
                        'tipo_empleado' => [
                            'id_tipo_empleado' => $empleadoTipo->id_tipo_empleado,
                            'nombre' => $empleadoTipo->tipoEmpleado->nombre,
                        ],
                        'sueldo_bruto' => $sueldobruto,
                        'ingresos' => $ingresos,
                        'egresos' => $egresos,
                        'aportes' => $aportes,
                        'sueldo_neto' => $sueldo_neto,
                    ];
                } catch (\Exception $e) {
                    Log::error("Error al procesar empleado con DNI: {$empleadoTipo->num_doc_iden} - {$e->getMessage()}");
                    continue;
                }
            }

            // Verificar si se generaron planillas
            if (empty($planillas)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se pudo generar ninguna planilla',
                ], 400);
            }

            // Retornar la planilla generada en formato JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Planilla generada exitosamente',
                'data' => $planillas,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al generar la planilla: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error inesperado al generar la planilla',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function generarBoletaIndividual($id_tipo_empleado, $num_doc_iden): JsonResponse
    {
        try {
            // Obtener el empleado por su tipo y número de documento
            $empleadoTipo = EmpleadoTipo::where('id_tipo_empleado', $id_tipo_empleado)
                ->whereHas('empleado', function ($query) use ($num_doc_iden) {
                    $query->where('num_doc_iden', $num_doc_iden);
                })
                ->with(['empleado', 'tipoEmpleado'])
                ->first();

            // Verificar si el empleado existe
            if (!$empleadoTipo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Empleado no encontrado',
                ], 404);
            }

            // Obtener la remuneración del empleado
            $remuneracion = Remuneracion::where('empleado_tipo_num_doc_iden', $num_doc_iden)
                ->where('empleado_tipo_id', $id_tipo_empleado)
                ->first();

            // Verificar si existe información de remuneración
            if (!$remuneracion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró información de remuneración para el empleado',
                ], 404);
            }

            $sueldobruto = $remuneracion->sueldo_bruto ?? 0;

            // Calcular los egresos (descuentos)
            $egresos = DB::table('detalle_egresos')
                ->where('empleado_tipo_num_doc_iden', $num_doc_iden)
                ->sum('monto');

            // Calcular los aportes
            $aportes = DB::table('detalle_aportacions')
                ->where('empleado_tipo_num_doc_iden', $num_doc_iden)
                ->sum('monto');

            // Calcular los ingresos adicionales
            $ingresos = DB::table('detalle_ingresos')
                ->where('empleado_tipo_num_doc_iden', $num_doc_iden)
                ->sum('monto');

            // Calcular el sueldo neto
            $sueldo_neto = $sueldobruto + $ingresos - $egresos - $aportes;

            // Crear la boleta de pago con los detalles
            $boleta = [
                'empleado' => [
                    'num_doc_iden' => $empleadoTipo->empleado->num_doc_iden,
                    'nombres' => $empleadoTipo->empleado->nombres,
                    'apellido_paterno' => $empleadoTipo->empleado->apellido_paterno,
                    'apellido_materno' => $empleadoTipo->empleado->apellido_materno,
                ],
                'tipo_empleado' => [
                    'id_tipo_empleado' => $empleadoTipo->id_tipo_empleado,
                    'nombre' => $empleadoTipo->tipoEmpleado->nombre,
                ],
                'sueldo_bruto' => $sueldobruto,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'aportes' => $aportes,
                'sueldo_neto' => $sueldo_neto,
                'fecha_generacion' => now()->format('Y-m-d H:i:s'),
            ];

            // Retornar la boleta generada en formato JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Boleta generada exitosamente',
                'data' => $boleta,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al generar boleta: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error al generar la boleta',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
