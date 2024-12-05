<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VacacionController extends Controller
{
    public function index()
    {
        try {
            $vacaciones = Vacacion::all();
            return response()->json($vacaciones, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las vacaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'empleado_tipo_id' => 'required|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'required|exists:empleado_tipos,num_doc_iden',
                'numero_dias' => 'required|integer',
                'periodo' => 'required|date',
                'detalle' => 'nullable|string',
                'estado' => 'required|boolean'
            ]);

            $vacacion = Vacacion::create($validated);

            return response()->json([
                'message' => 'Vacación registrada exitosamente',
                'data' => $vacacion
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la vacación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $vacacion = Vacacion::find($id);

        if (!$vacacion) {
            return response()->json([
                'message' => "La vacación con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($vacacion, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la vacación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $vacacion = Vacacion::find($id);

        if (!$vacacion) {
            return response()->json([
                'message' => "La vacación con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'numero_dias' => 'sometimes|integer',
                'periodo' => 'sometimes|date',
                'detalle' => 'nullable|string',
                'estado' => 'sometimes|boolean'
            ]);

            $vacacion->update($validated);

            return response()->json([
                'message' => 'Vacación actualizada exitosamente',
                'data' => $vacacion
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la vacación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $vacacion = Vacacion::find($id);

        if (!$vacacion) {
            return response()->json([
                'message' => "La vacación con ID {$id} no existe"
            ], 404);
        }

        try {
            $vacacion->update(['estado' => false]);
            return response()->json([
                'message' => 'Vacación inactivada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar la vacación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
