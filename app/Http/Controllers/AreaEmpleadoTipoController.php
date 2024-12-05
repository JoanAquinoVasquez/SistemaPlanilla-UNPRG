<?php

namespace App\Http\Controllers;

use App\Models\AreaEmpleadoTipo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AreaEmpleadoTipoController extends Controller
{
    public function index()
    {
        try {
            $areaEmpleadoTipos = AreaEmpleadoTipo::all();
            return response()->json($areaEmpleadoTipos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los registros de áreas y tipos de empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'empleado_tipo_id' => 'required|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'required|string|max:20|exists:empleado_tipos,num_doc_iden',
                'area_id' => 'required|exists:areas,id',
                'estado' => 'required|boolean'
            ]);

            $areaEmpleadoTipo = AreaEmpleadoTipo::create($validated);

            return response()->json([
                'message' => 'Registro creado exitosamente',
                'data' => $areaEmpleadoTipo
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $areaEmpleadoTipo = AreaEmpleadoTipo::find($id);

        if (!$areaEmpleadoTipo) {
            return response()->json([
                'message' => "El registro con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($areaEmpleadoTipo, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $areaEmpleadoTipo = AreaEmpleadoTipo::find($id);

        if (!$areaEmpleadoTipo) {
            return response()->json([
                'message' => "El registro con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'empleado_tipo_id' => 'sometimes|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'sometimes|string|max:20|exists:empleado_tipos,num_doc_iden',
                'area_id' => 'sometimes|exists:areas,id',
                'estado' => 'sometimes|boolean'
            ]);

            $areaEmpleadoTipo->update($validated);

            return response()->json([
                'message' => 'Registro actualizado exitosamente',
                'data' => $areaEmpleadoTipo
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $areaEmpleadoTipo = AreaEmpleadoTipo::find($id);

        if (!$areaEmpleadoTipo) {
            return response()->json([
                'message' => "El registro con ID {$id} no existe"
            ], 404);
        }

        try {
            $areaEmpleadoTipo->update(['estado' => false]);
            return response()->json([
                'message' => 'Registro inactivado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al inactivar el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
