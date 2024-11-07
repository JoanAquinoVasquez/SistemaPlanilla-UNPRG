<?php

namespace App\Http\Controllers;

use App\Models\ControlAsistencia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ControlAsistenciaController extends Controller
{
    public function index()
    {
        try {
            $asistencias = ControlAsistencia::all();
            return response()->json($asistencias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el control de asistencias',
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
                'numero_asistencias' => 'required|integer',
                'numero_inasistencias' => 'required|integer',
                'numero_tardanzas' => 'required|integer',
                'periodo' => 'required|date',
                'numero_permisos' => 'required|integer',
            ]);

            $controlAsistencia = ControlAsistencia::create($validated);

            return response()->json([
                'message' => 'Control de asistencia registrado exitosamente',
                'data' => $controlAsistencia
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el control de asistencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $controlAsistencia = ControlAsistencia::find($id);

        if (!$controlAsistencia) {
            return response()->json([
                'message' => "El control de asistencia con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($controlAsistencia, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el control de asistencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $controlAsistencia = ControlAsistencia::find($id);

        if (!$controlAsistencia) {
            return response()->json([
                'message' => "El control de asistencia con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'numero_asistencias' => 'sometimes|integer',
                'numero_inasistencias' => 'sometimes|integer',
                'numero_tardanzas' => 'sometimes|integer',
                'periodo' => 'sometimes|date',
                'numero_permisos' => 'sometimes|integer',
            ]);

            $controlAsistencia->update($validated);

            return response()->json([
                'message' => 'Control de asistencia actualizado exitosamente',
                'data' => $controlAsistencia
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el control de asistencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $controlAsistencia = ControlAsistencia::find($id);

        if (!$controlAsistencia) {
            return response()->json([
                'message' => "El control de asistencia con ID {$id} no existe"
            ], 404);
        }

        try {
            $controlAsistencia->delete();

            return response()->json([
                'message' => 'Control de asistencia eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el control de asistencia',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
