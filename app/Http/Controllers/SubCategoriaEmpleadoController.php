<?php

namespace App\Http\Controllers;

use App\Models\SubCategoriaEmpleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubCategoriaEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $subCategorias = SubCategoriaEmpleado::where('estado', 1)->get();
            return response()->json($subCategorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las subcategorías',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'categoria_empleado_id' => 'required|exists:categoria_empleados,id',
                'estado' => 'boolean'
            ]);

            $subCategoria = SubCategoriaEmpleado::create($validated);

            return response()->json([
                'message' => 'Subcategoría creada exitosamente',
                'data' => $subCategoria
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la subcategoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $subCategoria = SubCategoriaEmpleado::where('id', $id)->where('estado', 1)->first();

        if (!$subCategoria) {
            return response()->json([
                'message' => "La subcategoría con ID {$id} no existe o está inactiva"
            ], 404);
        }

        try {
            return response()->json($subCategoria, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la subcategoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $subCategoria = SubCategoriaEmpleado::find($id);

        if (!$subCategoria) {
            return response()->json([
                'message' => "La subcategoría con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:100',
                'descripcion' => 'nullable|string',
                'categoria_empleado_id' => 'sometimes|exists:categoria_empleados,id',
                'estado' => 'boolean'
            ]);

            $subCategoria->update($validated);

            return response()->json([
                'message' => 'Subcategoría actualizada exitosamente',
                'data' => $subCategoria
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la subcategoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $subCategoria = SubCategoriaEmpleado::find($id);

        if (!$subCategoria) {
            return response()->json([
                'message' => "La subcategoría con ID {$id} no existe"
            ], 404);
        }

        try {
            $subCategoria->update(['estado' => 0]);

            return response()->json([
                'message' => 'Subcategoría eliminada exitosamente (eliminación lógica)'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la subcategoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
