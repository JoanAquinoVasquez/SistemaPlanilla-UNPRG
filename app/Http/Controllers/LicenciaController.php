<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LicenciaController extends Controller
{
    public function index()
    {
        try {
            $licencias = Licencia::all();
            return response()->json($licencias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las licencias',
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
                'goze' => 'required|boolean',
                'detalle' => 'nullable|string',
                'estado' => 'required|boolean'
            ]);

            $licencia = Licencia::create($validated);

            return response()->json([
                'message' => 'Licencia registrada exitosamente',
                'data' => $licencia
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la licencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $licencia = Licencia::find($id);

        if (!$licencia) {
            return response()->json([
                'message' => "La licencia con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($licencia, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la licencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $licencia = Licencia::find($id);

        if (!$licencia) {
            return response()->json([
                'message' => "La licencia con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'numero_dias' => 'sometimes|integer',
                'goze' => 'sometimes|boolean',
                'detalle' => 'nullable|string',
                'estado' => 'sometimes|boolean'
            ]);

            $licencia->update($validated);

            return response()->json([
                'message' => 'Licencia actualizada exitosamente',
                'data' => $licencia
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la licencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $licencia = Licencia::find($id);

        if (!$licencia) {
            return response()->json([
                'message' => "La licencia con ID {$id} no existe"
            ], 404);
        }

        try {
            $licencia->update(['estado' => false]);
            return response()->json([
                'message' => 'Licencia inactivada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar la licencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
