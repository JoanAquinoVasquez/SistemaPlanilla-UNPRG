<?php

namespace App\Http\Controllers;

use App\Models\DetalleFamilia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetalleFamiliaController extends Controller
{
    public function index()
    {
        try {
            $detallesFamilia = DetalleFamilia::all();
            return response()->json($detallesFamilia, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los detalles de familia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tipo_doc' => 'required|string|max:30',
                'num_doc' => 'required|string|max:20|unique:detalle_familias,num_doc,NULL,tipo_doc,tipo_doc,' . $request->tipo_doc,
                'nombres' => 'required|string|max:50',
                'apellido_paterno' => 'required|string|max:50',
                'apellido_materno' => 'required|string|max:50',
                'telefono' => 'nullable|string|max:15',
                'fecha_nacimiento' => 'required|date',
                'nivel_escolaridad' => 'nullable|string|max:50',
                'dependiente' => 'boolean',
                'discapacidad' => 'boolean',
                'estado' => 'boolean',
                'empleado_num_doc_iden' => 'required|exists:empleados,num_doc_iden',
                'parentesco_id' => 'required|exists:parentescos,id'
            ]);

            $detalleFamilia = DetalleFamilia::create($validated);

            return response()->json([
                'message' => 'Detalle de familia registrado exitosamente',
                'data' => $detalleFamilia
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el detalle de familia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($tipo_doc, $num_doc)
    {
        $detalleFamilia = DetalleFamilia::where('tipo_doc', $tipo_doc)->where('num_doc', $num_doc)->first();

        if (!$detalleFamilia) {
            return response()->json([
                'message' => "El detalle de familia con documento {$tipo_doc} - {$num_doc} no existe"
            ], 404);
        }

        try {
            return response()->json($detalleFamilia, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el detalle de familia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $tipo_doc, $num_doc)
    {
        $detalleFamilia = DetalleFamilia::where('tipo_doc', $tipo_doc)->where('num_doc', $num_doc)->first();

        if (!$detalleFamilia) {
            return response()->json([
                'message' => "El detalle de familia con documento {$tipo_doc} - {$num_doc} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombres' => 'sometimes|string|max:50',
                'apellido_paterno' => 'sometimes|string|max:50',
                'apellido_materno' => 'sometimes|string|max:50',
                'telefono' => 'nullable|string|max:15',
                'fecha_nacimiento' => 'sometimes|date',
                'nivel_escolaridad' => 'nullable|string|max:50',
                'dependiente' => 'boolean',
                'discapacidad' => 'boolean',
                'estado' => 'boolean',
                'empleado_num_doc_iden' => 'sometimes|exists:empleados,num_doc_iden',
                'parentesco_id' => 'sometimes|exists:parentescos,id'
            ]);

            $detalleFamilia->update($validated);

            return response()->json([
                'message' => 'Detalle de familia actualizado exitosamente',
                'data' => $detalleFamilia
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el detalle de familia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($tipo_doc, $num_doc)
    {
        $detalleFamilia = DetalleFamilia::where('tipo_doc', $tipo_doc)->where('num_doc', $num_doc)->first();

        if (!$detalleFamilia) {
            return response()->json([
                'message' => "El detalle de familia con documento {$tipo_doc} - {$num_doc} no existe"
            ], 404);
        }

        try {
            $detalleFamilia->estado = 0;
            $detalleFamilia->save();

            return response()->json([
                'message' => 'Detalle de familia eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el detalle de familia',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
