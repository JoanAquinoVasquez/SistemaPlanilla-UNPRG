<?php

namespace App\Http\Controllers;

use App\Models\Parentesco;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ParentescoController extends Controller
{
    public function index()
    {
        try {
            $parentescos = Parentesco::all();
            return response()->json($parentescos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los parentescos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'tipo' => 'required|in:consanguinidad,afinidad',
                'nivel' => 'required|string|max:50'
            ]);

            $parentesco = Parentesco::create($validated);

            return response()->json([
                'message' => 'Parentesco creado exitosamente',
                'data' => $parentesco
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el parentesco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $parentesco = Parentesco::find($id);

        if (!$parentesco) {
            return response()->json([
                'message' => "El parentesco con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($parentesco, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el parentesco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $parentesco = Parentesco::find($id);

        if (!$parentesco) {
            return response()->json([
                'message' => "El parentesco con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'tipo' => 'sometimes|in:consanguinidad,afinidad',
                'nivel' => 'sometimes|string|max:50'
            ]);

            $parentesco->update($validated);

            return response()->json([
                'message' => 'Parentesco actualizado exitosamente',
                'data' => $parentesco
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el parentesco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $parentesco = Parentesco::find($id);

        if (!$parentesco) {
            return response()->json([
                'message' => "El parentesco con ID {$id} no existe"
            ], 404);
        }

        try {
            $parentesco->delete();

            return response()->json([
                'message' => 'Parentesco eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el parentesco',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
