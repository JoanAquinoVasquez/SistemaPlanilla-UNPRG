<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EgresoController extends Controller
{
    public function index()
    {
        try {
            $egresos = Egreso::all();
            return response()->json($egresos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los egresos',
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

            $egreso = Egreso::create($validated);

            return response()->json([
                'message' => 'Egreso registrado exitosamente',
                'data' => $egreso
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $egreso = Egreso::find($id);

        if (!$egreso) {
            return response()->json([
                'message' => "El egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($egreso, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $egreso = Egreso::find($id);

        if (!$egreso) {
            return response()->json([
                'message' => "El egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'formula_parametro_id' => 'sometimes|exists:formula_parametros,id',
                'concepto' => 'sometimes|string|max:255',
                'sujeto_ley' => 'sometimes|boolean'
            ]);

            $egreso->update($validated);

            return response()->json([
                'message' => 'Egreso actualizado exitosamente',
                'data' => $egreso
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $egreso = Egreso::find($id);

        if (!$egreso) {
            return response()->json([
                'message' => "El egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $egreso->delete();
            return response()->json([
                'message' => 'Egreso eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
