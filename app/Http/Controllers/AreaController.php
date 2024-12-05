<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AreaController extends Controller
{
    public function index()
    {
        try {
            $areas = Area::all();
            return response()->json($areas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las áreas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'oficina' => 'nullable|string|max:255',
                'unidad' => 'nullable|string|max:255',
                'facultad' => 'nullable|string|max:255',
                'escuela' => 'nullable|string|max:255',
                'estado' => 'required|boolean'
            ]);

            $area = Area::create($validated);

            return response()->json([
                'message' => 'Área registrada exitosamente',
                'data' => $area
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json([
                'message' => "El área con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($area, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json([
                'message' => "El área con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'oficina' => 'nullable|string|max:255',
                'unidad' => 'nullable|string|max:255',
                'facultad' => 'nullable|string|max:255',
                'escuela' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean'
            ]);

            $area->update($validated);

            return response()->json([
                'message' => 'Área actualizada exitosamente',
                'data' => $area
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json([
                'message' => "El área con ID {$id} no existe"
            ], 404);
        }

        try {
            $area->update(['estado' => false]);
            return response()->json([
                'message' => 'Área inactivada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
