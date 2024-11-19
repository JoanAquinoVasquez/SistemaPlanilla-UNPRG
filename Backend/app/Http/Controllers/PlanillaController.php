<?php

namespace App\Http\Controllers;

use App\Models\Aportacion;
use App\Models\Contrato;
use App\Models\DetalleAportacion;
use App\Models\DetalleEgreso;
use App\Models\DetalleIngreso;
use App\Models\Empleado;
use App\Models\EmpleadoTipo;
use App\Models\Planilla;
use App\Models\Remuneracion;
use App\Models\SubCategoriaEmpleado;
use App\Models\SubTipoEmpleado;
use App\Models\TipoEmpleado;
use Google\Service\ServiceControl\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanillaController extends Controller
{

    public function generarPlanilla(Request $request)
    {
        try {
            // Definir el periodo de la planilla (puedes cambiar estas fechas según sea necesario)
            $fechaInicio = '2024-10-01';
            $fechaFin = '2024-10-31';

            // Verificar si ya existe una planilla para el periodo especificado
            $planillaExistente = Planilla::where('fecha_inicio', $fechaInicio)
                ->where('fecha_fin', $fechaFin)
                ->first();

            // Si ya existe una planilla para este periodo, usarla
            /* if ($planillaExistente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se puede generar la planilla para este periodo, ya que ya esta generada.',
                ], 400);
            } else { */
            // Si no existe, crear una nueva planilla
            $planilla = Planilla::create([
                'user_id' => 1, //Auth::User->id();
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
            //return $empleadoTipos;

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
                    // Obtener el contrato activo del empleado y su sueldo bruto
                    Log::info("Procesando empleado con ID: {$empleadoTipo->id}");

                    // Obtener el contrato activo del empleado y su sueldo bruto
                    $contrato = Contrato::where('empleado_tipo_id', $empleadoTipo->id)
                        ->where('estado', true)
                        ->first();

                    if (!$contrato) {
                        throw new \Exception("No se encontró contrato activo para el empleado con ID: {$empleadoTipo->id}");
                    }

                    Log::info("Contrato encontrado para empleado con ID: {$empleadoTipo->id}");

                    $sueldoBruto = $contrato->sueldo_bruto;

                    // Crear una entrada en la tabla remuneracion
                    $remuneracion = Remuneracion::create([
                        'planilla_id' => $planilla->id,
                        'empleado_tipo_id' => $empleadoTipo->id,
                        'sueldo_bruto' => $sueldoBruto,
                        'total_ingreso' => 0.0,
                        'total_egreso' => 0.0,
                        'sueldo_aporte' => 0.0,
                        'sueldo_neto' => 0.0
                    ]);

                    Log::info("Remuneración creada para empleado con ID: {$empleadoTipo->id}");

                    // Filtrar y calcular los ingresos adicionales dentro del periodo
                    $ingresos = DetalleIngreso::where('empleado_tipo_id', $empleadoTipo->id)
                        ->where(function ($query) use ($fechaInicio, $fechaFin) {
                            $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                        })
                        ->sum('monto');


                    // Filtrar y calcular los egresos dentro del periodo
                    $egresos = DetalleEgreso::where('empleado_tipo_id', $empleadoTipo->id)
                        ->where(function ($query) use ($fechaInicio, $fechaFin) {
                            $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                        })
                        ->sum('monto');

                    // Filtrar y calcular los aportes dentro del periodo
                    $aportes = DetalleAportacion::where('empleado_tipo_id', $empleadoTipo->id)
                        ->where(function ($query) use ($fechaInicio, $fechaFin) {
                            $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                        })
                        ->sum('monto');

                    $aportesPen = DetalleAportacion::where('empleado_tipo_id', $empleadoTipo->id)
                        ->whereHas('aportacion', function ($query) {
                            $query->whereIn('concepto', ['AFP', 'ONP']);
                        })
                        ->where(function ($query) use ($fechaInicio, $fechaFin) {
                            $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                        })
                        ->sum('monto');

                    Log::info("Aportes sistema pensiones: {$aportesPen}");

                    // Calcular el sueldo neto
                    $sueldo_neto = $sueldoBruto + $ingresos - $egresos - $aportesPen;

                    // Actualizar la remuneración con los valores calculados
                    $remuneracion->update([
                        'total_ingreso' => $ingresos,
                        'total_egreso' => $egresos,
                        'sueldo_aporte' => $aportes,
                        'sueldo_neto' => $sueldo_neto
                    ]);

                    // Agregar el resultado al array de planillas
                    $planillas[] = [
                        'id_planilla' => $planilla->id,
                        'empleado' => [
                            'num_doc_iden' => $empleadoTipo->empleado->num_doc_iden,
                            'nombres' => $empleadoTipo->empleado->nombres,
                            'apellido_paterno' => $empleadoTipo->empleado->apellido_paterno,
                            'apellido_materno' => $empleadoTipo->empleado->apellido_materno,
                        ],
                        'tipo_empleado' => [
                            'id_tipo_empleado' => $empleadoTipo->tipoEmpleado->id,
                            'nombre' => $empleadoTipo->tipoEmpleado->nombre,
                        ],
                        'sueldo_bruto' => $sueldoBruto,
                        'ingresos' => $ingresos,
                        'egresos' => $egresos,
                        'aportes' => $aportes,
                        'aportes_sistema_pensiones' => $aportesPen,
                        'sueldo_neto' => $sueldo_neto,
                    ];
                } catch (\Exception $e) {
                    Log::error("Error al procesar empleado con ID: {$empleadoTipo->id} - {$e->getMessage()}");
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

    public function generarBoletaIndividual($id): JsonResponse
    {
        try {
            // Obtener el empleado por su tipo y número de documento
            $empleadoTipo = EmpleadoTipo::where('id', $id)
                ->first();

            // Verificar si el empleado existe
            if (!$empleadoTipo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Empleado no encontrado',
                ], 404);
            }

            // Obtener la remuneración del empleado
            $remuneracion = Remuneracion::where('empleado_tipo_num_doc_iden', $empleadoTipo->num_doc_iden)
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

            // Crear la boleta de pago con los detalles
            $boleta = [
                'empleado' => [
                    'num_doc_iden' => $empleadoTipo->empleado->num_doc_iden,
                    'nombres' => $empleadoTipo->empleado->nombres,
                    'apellido_paterno' => $empleadoTipo->empleado->apellido_paterno,
                    'apellido_materno' => $empleadoTipo->empleado->apellido_materno,
                ],
                'tipo_empleado' => [
                    'id_tipo_empleado' => $empleadoTipo->tipoEmpleado->id,
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

    public function testing(){
        $subCategoria = SubCategoriaEmpleado::all();/* with('tipoEmpleado', 'categorias')->get(); */
        return $subCategoria;
    }
}
