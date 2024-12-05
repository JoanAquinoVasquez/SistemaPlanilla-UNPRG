<?php

namespace App\Http\Controllers;

use App\Models\Aportacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AportacionController extends Controller
{
    public function index()
    {
        try {
            $aportaciones = Aportacion::all();
            return response()->json($aportaciones, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las aportaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'formula_parametro_id' => 'required|exists:formula_parametros,id',
                'concepto' => 'required|string|max:255',
                'sujeto_ley' => 'required|boolean'
            ]);

            $aportacion = Aportacion::create($validated);

            return response()->json([
                'message' => 'Aportación registrada exitosamente',
                'data' => $aportacion
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la aportación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $aportacion = Aportacion::find($id);

        if (!$aportacion) {
            return response()->json([
                'message' => "La aportación con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($aportacion, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la aportación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $aportacion = Aportacion::find($id);

        if (!$aportacion) {
            return response()->json([
                'message' => "La aportación con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'formula_parametro_id' => 'sometimes|exists:formula_parametros,id',
                'concepto' => 'sometimes|string|max:255',
                'sujeto_ley' => 'sometimes|boolean'
            ]);

            $aportacion->update($validated);

            return response()->json([
                'message' => 'Aportación actualizada exitosamente',
                'data' => $aportacion
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la aportación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $aportacion = Aportacion::find($id);

        if (!$aportacion) {
            return response()->json([
                'message' => "La aportación con ID {$id} no existe"
            ], 404);
        }

        try {
            $aportacion->delete();
            return response()->json([
                'message' => 'Aportación eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la aportación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
