<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmpleadoController extends Controller
{
    public function index()
    {
        try {
            $empleados = Empleado::all();
            return response()->json($empleados, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'num_doc_iden' => 'required|string|unique:empleados|max:50',
                'nombres' => 'required|string|max:50',
                'apellido_paterno' => 'required|string|max:50',
                'apellido_materno' => 'required|string|max:50',
                'tipo_doc_iden' => 'required|string|max:50',
                'fecha_nacimiento' => 'required|date',
                'sexo' => 'required|string|max:50',
                'estado_civil' => 'nullable|in:Soltero,Casado,Viudo,Divorciado',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'required|string|max:15',
                'email' => 'required|email|unique:empleados,email',
                'estado' => 'boolean'
            ]);

            $empleado = Empleado::create($validated);

            return response()->json([
                'message' => 'Empleado registrado exitosamente',
                'data' => $empleado
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'message' => "El empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($empleado, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'message' => "El empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombres' => 'sometimes|string|max:50',
                'apellido_paterno' => 'sometimes|string|max:50',
                'apellido_materno' => 'sometimes|string|max:50',
                'tipo_doc_iden' => 'sometimes|string|max:50',
                'fecha_nacimiento' => 'sometimes|date',
                'sexo' => 'sometimes|string|max:50',
                'estado_civil' => 'nullable|in:Soltero,Casado,Viudo,Divorciado',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'sometimes|string|max:15',
                'email' => 'sometimes|email|unique:empleados,email,' . $empleado->num_doc_iden,
                'estado' => 'boolean'
            ]);

            $empleado->update($validated);

            return response()->json([
                'message' => 'Empleado actualizado exitosamente',
                'data' => $empleado
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'message' => "El empleado con ID {$id} no existe"
            ], 404);
        }

        try {
            $empleado->estado = 0;
            $empleado->save();

            return response()->json([
                'message' => 'Empleado eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
