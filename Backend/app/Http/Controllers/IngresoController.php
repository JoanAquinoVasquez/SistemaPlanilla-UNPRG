<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IngresoController extends Controller
{
    public function index()
    {
        try {
            $ingresos = Ingreso::all();
            return response()->json($ingresos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las ingresos',
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

            $ingreso = Ingreso::create($validated);

            return response()->json([
                'message' => 'Ingreso registrado exitosamente',
                'data' => $ingreso
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $ingreso = Ingreso::find($id);

        if (!$ingreso) {
            return response()->json([
                'message' => "El ingreso con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($ingreso, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $ingreso = Ingreso::find($id);

        if (!$ingreso) {
            return response()->json([
                'message' => "El ingreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'formula_parametro_id' => 'sometimes|exists:formula_parametros,id',
                'concepto' => 'sometimes|string|max:255',
                'sujeto_ley' => 'sometimes|boolean'
            ]);

            $ingreso->update($validated);

            return response()->json([
                'message' => 'Ingreso actualizado exitosamente',
                'data' => $ingreso
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::find($id);

        if (!$ingreso) {
            return response()->json([
                'message' => "El ingreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $ingreso->delete();
            return response()->json([
                'message' => 'Ingreso eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
