<?php

namespace App\Http\Controllers;

use App\Models\FormulaParametro;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FormulaParametroController extends Controller
{
    public function index()
    {
        try {
            $formulaParametros = FormulaParametro::with(['formula', 'parametro'])->get();
            return response()->json($formulaParametros, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las relaciones de fórmula y parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'formula_id' => 'required|exists:formulas,id',
                'parametro_id' => 'required|exists:parametros,id',
                'operacion' => 'required|string|max:50',
                'estado' => 'sometimes|boolean',
            ]);

            $formulaParametro = FormulaParametro::create($validated);

            return response()->json([
                'message' => 'Relación de fórmula y parámetro creada exitosamente',
                'data' => $formulaParametro
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la relación de fórmula y parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $formulaParametro = FormulaParametro::with(['formula', 'parametro'])->find($id);

        if (!$formulaParametro) {
            return response()->json([
                'message' => "La relación con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($formulaParametro, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la relación de fórmula y parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $formulaParametro = FormulaParametro::find($id);

        if (!$formulaParametro) {
            return response()->json([
                'message' => "La relación con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'formula_id' => 'sometimes|exists:formulas,id',
                'parametro_id' => 'sometimes|exists:parametros,id',
                'operacion' => 'sometimes|string|max:50',
                'estado' => 'sometimes|boolean',
            ]);

            $formulaParametro->update($validated);

            return response()->json([
                'message' => 'Relación de fórmula y parámetro actualizada exitosamente',
                'data' => $formulaParametro
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la relación de fórmula y parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $formulaParametro = FormulaParametro::find($id);

        if (!$formulaParametro) {
            return response()->json([
                'message' => "La relación con ID {$id} no existe"
            ], 404);
        }

        try {
            $formulaParametro->delete();
            return response()->json([
                'message' => 'Relación de fórmula y parámetro eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la relación de fórmula y parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
