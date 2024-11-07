<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEmpleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriaEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $categorias = CategoriaEmpleado::where('estado', 1)->get();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener categorías de empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sub_tipo_empleado_id' => 'required|exists:sub_tipo_empleados,id',
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string'
            ]);

            $categoria = CategoriaEmpleado::create(array_merge($validated, ['estado' => 1]));

            return response()->json([
                'message' => 'Registro exitoso',
                'data' => $categoria
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la categoría de empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $categoria = CategoriaEmpleado::where('id', $id)->where('estado', 1)->first();

        if (!$categoria) {
            return response()->json([
                'message' => "La categoría con ID {$id} no existe o ha sido eliminada"
            ], 404);
        }

        try {
            return response()->json($categoria, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, CategoriaEmpleado $categoriaEmpleado)
    {
        try {
            $validated = $request->validate([
                'sub_tipo_empleado_id' => 'sometimes|exists:sub_tipo_empleados,id',
                'nombre' => 'sometimes|string|max:100',
                'descripcion' => 'nullable|string'
            ]);

            $categoriaEmpleado->update($validated);

            return response()->json([
                'message' => 'Categoría actualizada exitosamente',
                'data' => $categoriaEmpleado
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $categoria = CategoriaEmpleado::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => "La categoría con ID {$id} no existe"
            ], 404);
        }

        try {
            $categoria->update(['estado' => 0]);
            return response()->json([
                'message' => 'Categoría eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
