<?php

namespace App\Http\Controllers;

use App\Models\DetalleEgreso;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetalleEgresoController extends Controller
{
    public function index()
    {
        try {
            $detalles = DetalleEgreso::all();
            return response()->json($detalles, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los detalles de egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'aportacions_id' => 'required|exists:aportacions,id',
                'remuneracion_id' => 'required|exists:remuneracions,id',
                'empleado_tipo_id' => 'required|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'required|exists:empleado_tipos,num_doc_iden',
                'monto' => 'required|numeric|min:0'
            ]);

            $detalle = DetalleEgreso::create($validated);

            return response()->json([
                'message' => 'Detalle de egreso registrado exitosamente',
                'data' => $detalle
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el detalle de egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $detalle = DetalleEgreso::find($id);

        if (!$detalle) {
            return response()->json([
                'message' => "El detalle de egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($detalle, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el detalle de egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleEgreso::find($id);

        if (!$detalle) {
            return response()->json([
                'message' => "El detalle de egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'aportacions_id' => 'sometimes|exists:aportacions,id',
                'remuneracion_id' => 'sometimes|exists:remuneracions,id',
                'empleado_tipo_id' => 'sometimes|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'sometimes|exists:empleado_tipos,num_doc_iden',
                'monto' => 'sometimes|numeric|min:0'
            ]);

            $detalle->update($validated);

            return response()->json([
                'message' => 'Detalle de egreso actualizado exitosamente',
                'data' => $detalle
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el detalle de egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $detalle = DetalleEgreso::find($id);

        if (!$detalle) {
            return response()->json([
                'message' => "El detalle de egreso con ID {$id} no existe"
            ], 404);
        }

        try {
            $detalle->delete();
            return response()->json([
                'message' => 'Detalle de egreso eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el detalle de egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
