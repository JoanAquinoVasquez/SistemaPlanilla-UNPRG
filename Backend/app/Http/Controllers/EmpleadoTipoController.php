<?php

namespace App\Http\Controllers;

use App\Models\AreaEmpleadoTipo;
use App\Models\DetalleAportacion;
use App\Models\Empleado;
use App\Models\EmpleadoTipo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmpleadoTipoController extends Controller
{
    public function index()
    {
        try {
            $empleadoTipos = EmpleadoTipo::all();
            return response()->json($empleadoTipos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los tipos de empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_tipo_empleado' => 'required|exists:tipo_empleados,id',
                'num_doc_iden' => 'required|string|max:20|exists:empleados,num_doc_iden',
                'banco_id' => 'required|exists:bancos,id',
                'tipo_cuenta' => 'required|string|max:50',
                'cci' => 'required|string|max:20',
                'numero_cuenta' => 'required|string|max:20'
            ]);

            $empleadoTipo = EmpleadoTipo::create($validated);

            return response()->json([
                'message' => 'Registro de tipo de empleado exitoso',
                'data' => $empleadoTipo
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el tipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($idTipoEmpleado, $numDocIden)
    {
        $empleadoTipo = EmpleadoTipo::where('id_tipo_empleado', $idTipoEmpleado)
            ->where('num_doc_iden', $numDocIden)
            ->first();

        if (!$empleadoTipo) {
            return response()->json([
                'message' => "El tipo de empleado con ID {$idTipoEmpleado} y documento {$numDocIden} no existe"
            ], 404);
        }

        try {
            return response()->json($empleadoTipo, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el tipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEmpleadoTipoData($id)
    {
        try {
            // Buscar el EmpleadoTipo por su ID
            $empleadoTipo = EmpleadoTipo::with(['empleado', 'tipoEmpleado', 'areaActiva.area', 'aportacionPension'])
                ->where('tipo_empleado_id', $id)
                ->get();

            // Verificar si el EmpleadoTipo existe
            if ($empleadoTipo->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'EmpleadoTipo no encontrado.',
                ], 404);
            }

            // Retornar los datos con éxito
            return response()->json([
                'success' => true,
                'data' => $empleadoTipo,
            ], 200);
        } catch (\Exception $e) {
            // Capturar excepciones y retornar un error interno del servidor
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del EmpleadoTipo.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function allPracticantes($id)
    {
        /* $empleadosConAportacion = EmpleadoTipo::with(['detalleAportaciones.aportacion'])
            ->where('id_tipo_empleado', $id)
            ->whereHas('detalleAportaciones.aportacion', function ($query) {
                $query->whereIn('concepto', ['Aporte a AFP Habitat', 'Aporte a AFP Integra', 
                'Aporte a Prima AFP', 'Aporte a Profundo AFP', 'Aporte a ONP']);
            })
            ->get();
        return $empleadosConAportacion; */
        /* $empleado_tipos = EmpleadoTipo::all(); */

        $empleado_tipos = EmpleadoTipo::with(['empleado', 'tipoEmpleado.subTipoEmpleado', 'detalleAportaciones.aportacion'])
            ->where('id_tipo_empleado', $id)
            ->whereHas('detalleAportaciones.aportacion', function ($query) {
                $query->whereIn('concepto', [
                    'AFP Habitat',
                    'AFP Integra',
                    'Prima AFP',
                    'Profundo AFP',
                    'ONP'
                ]);
            })->get();

        //Dreturn $empleado_tipos;

        $empleadosTipos = [];

        foreach ($empleado_tipos as $empleado_tipo) {
            $aportaciones = $empleado_tipo->detalleAportaciones->map(function ($detalle) {
                return $detalle->aportacion->concepto;
            })->unique()->values()->all();

            $empleadosTipos[] = [
                'nombres' => $empleado_tipo->empleado->nombres,
                'tipo_empleado' => $empleado_tipo->tipoEmpleado->nombre,
                'apellido_paterno' => $empleado_tipo->empleado->apellido_paterno,
                'apellido_materno' => $empleado_tipo->empleado->apellido_materno,
                'num_doc_iden' => $empleado_tipo->num_doc_iden,
                'numero_cuenta' => $empleado_tipo->numero_cuenta,
                'cci' => $empleado_tipo->cci,
                'aporte' => $aportaciones, // Aportaciones únicas en formato array
                'area' => 'EPG', // Cambiar si es necesario, aquí es un valor fijo
                'estado' => $empleado_tipo->estado
            ];
        }

        /* $detalleAportaciones = DetalleAportacion::all()->map(function ($detalle) {
            $detalle->empleadoTipo = EmpleadoTipo::where('id_tipo_empleado', $detalle->empleado_tipo_id)
                ->where('num_doc_iden', $detalle->empleado_tipo_num_doc_iden)
                ->first();
            return $detalle;
        }); */

        return $empleadosTipos;

        /* try {
            $tipoEmpleado = EmpleadoTipo::with(['tipoEmpleado.subTipoEmpleado', 'detalleAportacion.aportacion'])
            ->where('id_tipo_empleado', $id)->get(); 
            $tipoEmpleado = EmpleadoTipo::with(['tipoEmpleado', 'tipoEmpleado.subTipoEmpleado', 'detalleAportacion.aportacion'])
                ->where('id_tipo_empleado', $id)->get();
            //return $tipoEmpleado;
            return response()->json($tipoEmpleado, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los tipos de empleados',
                'error' => $e->getMessage()
            ], 500);
        } */
    }

    public function update(Request $request, $idTipoEmpleado, $numDocIden)
    {
        $empleadoTipo = EmpleadoTipo::where('id_tipo_empleado', $idTipoEmpleado)
            ->where('num_doc_iden', $numDocIden)
            ->first();

        if (!$empleadoTipo) {
            return response()->json([
                'message' => "El tipo de empleado con ID {$idTipoEmpleado} y documento {$numDocIden} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'banco_id' => 'sometimes|exists:bancos,id',
                'tipo_cuenta' => 'sometimes|string|max:50',
                'cci' => 'sometimes|string|max:20',
                'numero_cuenta' => 'sometimes|string|max:20'
            ]);

            $empleadoTipo->update($validated);

            return response()->json([
                'message' => 'Tipo de empleado actualizado exitosamente',
                'data' => $empleadoTipo
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el tipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($idTipoEmpleado, $numDocIden)
    {
        $empleadoTipo = EmpleadoTipo::where('id_tipo_empleado', $idTipoEmpleado)
            ->where('num_doc_iden', $numDocIden)
            ->first();

        if (!$empleadoTipo) {
            return response()->json([
                'message' => "El tipo de empleado con ID {$idTipoEmpleado} y documento {$numDocIden} no existe"
            ], 404);
        }

        try {
            $empleadoTipo->delete();

            return response()->json([
                'message' => 'Tipo de empleado eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el tipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
