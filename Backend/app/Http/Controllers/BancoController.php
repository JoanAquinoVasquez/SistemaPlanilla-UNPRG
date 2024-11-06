<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BancoController extends Controller
{
    public function index()
    {
        try {
            $bancos = Banco::all();

            $data = [
                'message' => $bancos->isEmpty() ? 'No se han encontrado bancos' : 'Bancos encontrados',
                'status' => 200,
                'data' => $bancos
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al recuperar los bancos.',
                'status' => 500,
                'error' => $e->getMessage() // En producción, evita enviar mensajes de error específicos
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255'
        ]);

        try {
            // Creación del banco
            $banco = Banco::create($validatedData);

            // Respuesta exitosa
            return response()->json([
                'message' => 'Banco creado exitosamente',
                'status' => 201,
                'data' => $banco
            ], 201);
        } catch (\Exception $e) {
            // Manejo de errores: registro en logs y respuesta genérica
            Log::error("Error al crear banco: " . $e->getMessage());
            
            return response()->json([
                'message' => 'Ocurrió un error al crear el banco. Por favor, intente nuevamente.',
                'status' => 500
            ], 500);
        }
    }

    public function show(Banco $banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banco $banco)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banco $banco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banco $banco)
    {
        //
    }
}
