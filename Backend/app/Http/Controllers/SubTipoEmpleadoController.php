<?php

namespace App\Http\Controllers;

use App\Models\SubTipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubTipoEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $subTipoEmpleados = SubTipoEmpleado::all();
            return response()->json($subTipoEmpleados, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener subtipos de empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_empleado_id' => 'required|exists:tipo_empleados,id'
            ]);

            $subTipoEmpleado = SubTipoEmpleado::create($validated);

            return response()->json([
                'message' => 'Subtipo de empleado creado exitosamente',
                'data' => $subTipoEmpleado
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el subtipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $subTipoEmpleado = SubTipoEmpleado::find($id);

        if (!$subTipoEmpleado) {
            return response()->json([
                'message' => "El subtipo de empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($subTipoEmpleado, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el subtipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, SubTipoEmpleado $subTipoEmpleado)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_empleado_id' => 'sometimes|exists:tipo_empleados,id'
            ]);

            $subTipoEmpleado->update($validated);
            return response()->json([
                'message' => 'Subtipo de empleado actualizado exitosamente',
                'data' => $subTipoEmpleado
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el subtipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $subTipoEmpleado = SubTipoEmpleado::find($id);

        if (!$subTipoEmpleado) {
            return response()->json([
                'message' => "El subtipo de empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            $subTipoEmpleado->update(['estado' => 0]);
            return response()->json([
                'message' => 'Subtipo de empleado eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el subtipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
