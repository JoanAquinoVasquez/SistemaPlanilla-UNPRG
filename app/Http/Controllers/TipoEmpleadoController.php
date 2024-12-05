<?php

namespace App\Http\Controllers;

use App\Models\TipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $tipoEmpleados = TipoEmpleado::all();
            return response()->json($tipoEmpleados, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener tipos de empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string'
            ]);

            $tipoEmpleado = TipoEmpleado::create($validated);

            return response()->json([
                'message' => 'Registro exitoso',
                'data' => $tipoEmpleado
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

    public function show($id)
    {
        $tipoEmpleado = TipoEmpleado::find($id);

        if (!$tipoEmpleado) {
            return response()->json([
                'message' => "El tipo de empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($tipoEmpleado, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el tipo de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, TipoEmpleado $tipoEmpleado)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:50',
                'descripcion' => 'nullable|string'
            ]);

            $tipoEmpleado->update($validated);
            return response()->json([
                'message' => 'Tipo de empleado actualizado exitosamente',
                'data' => $tipoEmpleado
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

    public function destroy($id)
    {
        $tipoEmpleado = TipoEmpleado::find($id);

        if (!$tipoEmpleado) {
            return response()->json([
                'message' => "El tipo de empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            $tipoEmpleado->update(['estado' => 0]);
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
