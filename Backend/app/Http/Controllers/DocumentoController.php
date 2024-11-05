<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DocumentoController extends Controller
{
    public function index()
    {
        try {
            $documentos = Documento::all();
            return response()->json($documentos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener documentos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
                'fecha_vigencia' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_vigencia',
                'estado' => 'required|boolean'
            ]);

            $documento = Documento::create($validated);

            return response()->json([
                'message' => 'Registro exitoso',
                'data' => $documento
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json([
                'message' => "El documento con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($documento, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, Documento $documento)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'tipo' => 'sometimes|string|max:255',
                'fecha_vigencia' => 'sometimes|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_vigencia',
                'estado' => 'sometimes|boolean'
            ]);

            $documento->update($validated);
            return response()->json([
                'message' => 'Documento actualizado exitosamente',
                'data' => $documento
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json([
                'message' => "El documento con ID {$id} no existe"
            ], 404);
        }

        try {
            $documento->delete();
            return response()->json([
                'message' => 'Documento eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
