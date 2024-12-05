<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PrestamoController extends Controller
{
    public function index()
    {
        try {
            $prestamos = Prestamo::all();
            return response()->json($prestamos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los préstamos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'empleado_tipo_id' => 'required|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'required|string|exists:empleado_tipos,num_doc_iden',
                'banco_id' => 'required|exists:bancos,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'monto_prestado' => 'required|numeric',
                'monto_restante' => 'required|numeric',
                'numero_cuotas' => 'required|integer',
                'estado' => 'required|boolean'
            ]);

            $prestamo = Prestamo::create($validated);

            return response()->json([
                'message' => 'Préstamo registrado exitosamente',
                'data' => $prestamo
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $prestamo = Prestamo::find($id);

        if (!$prestamo) {
            return response()->json([
                'message' => "El préstamo con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($prestamo, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);

        if (!$prestamo) {
            return response()->json([
                'message' => "El préstamo con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'fecha_inicio' => 'sometimes|date',
                'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
                'monto_prestado' => 'sometimes|numeric',
                'monto_restante' => 'sometimes|numeric',
                'numero_cuotas' => 'sometimes|integer',
                'estado' => 'sometimes|boolean'
            ]);

            $prestamo->update($validated);

            return response()->json([
                'message' => 'Préstamo actualizado exitosamente',
                'data' => $prestamo
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $prestamo = Prestamo::find($id);

        if (!$prestamo) {
            return response()->json([
                'message' => "El préstamo con ID {$id} no existe"
            ], 404);
        }

        try {
            $prestamo->update(['estado' => false]);
            return response()->json([
                'message' => 'Préstamo inactivado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
