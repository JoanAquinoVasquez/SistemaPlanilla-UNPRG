<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CuotaController extends Controller
{
    public function index()
    {
        try {
            $cuotas = Cuota::all();
            return response()->json($cuotas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las cuotas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'prestamo_id' => 'required|exists:prestamos,id',
                'fecha' => 'required|date',
                'monto' => 'required|numeric',
                'estado' => 'required|boolean'
            ]);

            $cuota = Cuota::create($validated);

            return response()->json([
                'message' => 'Cuota registrada exitosamente',
                'data' => $cuota
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la cuota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $cuota = Cuota::find($id);

        if (!$cuota) {
            return response()->json([
                'message' => "La cuota con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($cuota, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la cuota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $cuota = Cuota::find($id);

        if (!$cuota) {
            return response()->json([
                'message' => "La cuota con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'fecha' => 'sometimes|date',
                'monto' => 'sometimes|numeric',
                'estado' => 'sometimes|boolean'
            ]);

            $cuota->update($validated);

            return response()->json([
                'message' => 'Cuota actualizada exitosamente',
                'data' => $cuota
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la cuota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $cuota = Cuota::find($id);

        if (!$cuota) {
            return response()->json([
                'message' => "La cuota con ID {$id} no existe"
            ], 404);
        }

        try {
            $cuota->update(['estado' => false]);
            return response()->json([
                'message' => 'Cuota inactivada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar la cuota',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
