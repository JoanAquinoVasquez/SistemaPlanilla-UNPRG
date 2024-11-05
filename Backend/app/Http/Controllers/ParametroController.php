<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ParametroController extends Controller
{
    public function index()
    {
        try {
            $parametros = Parametro::all();
            return response()->json($parametros, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener parámetros',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'valor' => 'required|numeric', // Permitir valores numéricos (decimales o enteros)
                'documento_id' => 'required|exists:documentos,id', // Verifica que el documento exista
                'estado' => 'sometimes|boolean'
            ]);

            $parametro = Parametro::create($validated);

            return response()->json([
                'message' => 'Parámetro creado exitosamente',
                'data' => $parametro
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $parametro = Parametro::find($id);

        if (!$parametro) {
            return response()->json([
                'message' => "El parámetro con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($parametro, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $parametro = Parametro::find($id);

        if (!$parametro) {
            return response()->json([
                'message' => "El parámetro con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'valor' => 'sometimes|numeric', // Permitir valores numéricos (decimales o enteros)
                'documento_id' => 'sometimes|exists:documentos,id', // Verifica que el documento exista si se proporciona
                'estado' => 'sometimes|boolean'
            ]);

            $parametro->update($validated);

            return response()->json([
                'message' => 'Parámetro actualizado exitosamente',
                'data' => $parametro
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $parametro = Parametro::find($id);

        if (!$parametro) {
            return response()->json([
                'message' => "El parámetro con ID {$id} no existe"
            ], 404);
        }

        try {
            $parametro->delete();
            return response()->json([
                'message' => 'Parámetro eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el parámetro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
