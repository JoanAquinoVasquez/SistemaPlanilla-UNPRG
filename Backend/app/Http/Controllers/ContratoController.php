<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContratoController extends Controller
{
    public function index()
    {
        try {
            $contratos = Contrato::all();
            return response()->json($contratos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los contratos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'empleado_tipo_id' => 'required|exists:empleado_tipos,id_tipo_empleado',
                'empleado_tipo_num_doc_iden' => 'required|string|exists:empleado_tipos,num_doc_iden',
                'sueldo_bruto' => 'required|numeric',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'estado' => 'required|boolean',
                'tipo_documento' => 'required|string|max:50',
                'numero_documento' => 'required|string|max:20',
                'regimen_laboral' => 'required|string|max:50',
                'horas_trabajo' => 'required|integer',
            ]);

            $contrato = Contrato::create($validated);

            return response()->json([
                'message' => 'Contrato registrado exitosamente',
                'data' => $contrato
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el contrato',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return response()->json([
                'message' => "El contrato con ID {$id} no existe"
            ], 404);
        }

        try {
            return response()->json($contrato, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el contrato',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return response()->json([
                'message' => "El contrato con ID {$id} no existe"
            ], 404);
        }

        try {
            $validated = $request->validate([
                'sueldo_bruto' => 'sometimes|numeric',
                'fecha_inicio' => 'sometimes|date',
                'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
                'estado' => 'sometimes|boolean',
                'tipo_documento' => 'sometimes|string|max:50',
                'numero_documento' => 'sometimes|string|max:20',
                'regimen_laboral' => 'sometimes|string|max:50',
                'horas_trabajo' => 'sometimes|integer',
            ]);

            $contrato->update($validated);

            return response()->json([
                'message' => 'Contrato actualizado exitosamente',
                'data' => $contrato
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el contrato',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $contrato = Contrato::find($id);

        if (!$contrato) {
            return response()->json([
                'message' => "El contrato con ID {$id} no existe"
            ], 404);
        }

        try {
            $contrato->update(['estado' => false]);
            return response()->json([
                'message' => 'Contrato desactivado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al desactivar el contrato',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
