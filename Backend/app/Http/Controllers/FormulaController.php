<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FormulaController extends Controller
{
    public function index()
    {
        try {
            $formulas = Formula::all();
            return response()->json($formulas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener fórmulas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
            ]);

            $formula = Formula::create($validated);

            return response()->json([
                'message' => 'Registro exitoso',
                'data' => $formula
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la fórmula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $formula = Formula::find($id);

        if (!$formula) {
            return response()->json([
                'message' => "La fórmula con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($formula, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la fórmula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $formula = Formula::find($id);

        if (!$formula) {
            return response()->json([
                'message' => "La fórmula con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'sometimes|string',
            ]);

            $formula->update($validated);

            return response()->json([
                'message' => 'Fórmula actualizada exitosamente',
                'data' => $formula
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la fórmula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $formula = Formula::find($id);

        if (!$formula) {
            return response()->json([
                'message' => "La fórmula con ID {$id} no existe"
            ], 404);
        }

        try {
            $formula->delete();
            return response()->json([
                'message' => 'Fórmula eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la fórmula',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
