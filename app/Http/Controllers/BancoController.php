<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BancoController extends Controller
{
    public function index()
    {
        try {
            $bancos = Banco::where('estado', 1)->get();
            return response()->json($bancos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener bancos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string',
                'estado' => 'required|boolean'
            ]);

            $banco = Banco::create($validated);

            return response()->json([
                'message' => 'Banco registrado exitosamente',
                'data' => $banco
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el banco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $banco = Banco::find($id);

        if (!$banco || $banco->estado == 0) {
            return response()->json([
                'message' => "El banco con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($banco, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el banco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Banco $banco)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:50',
                'descripcion' => 'nullable|string',
                'estado' => 'sometimes|boolean'
            ]);

            $banco->update($validated);

            return response()->json([
                'message' => 'Banco actualizado exitosamente',
                'data' => $banco
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el banco',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $banco = Banco::find($id);

        if (!$banco || $banco->estado == 0) {
            return response()->json([
                'message' => "El banco con ID {$id} no existe"
            ], 404);
        }

        try {
            $banco->estado = 0;
            $banco->save();

            return response()->json([
                'message' => 'Banco eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el banco',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
