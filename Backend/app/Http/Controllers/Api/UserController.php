<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        Log::info('Obteniendo todos los usuarios');
        return User::all();
    }

    // Obtener un usuario por ID
    public function show($id)
    {
        Log::info("Obteniendo el usuario con ID: {$id}");
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        Log::info('Creando un nuevo usuario', ['data' => $request->all()]);

        // Validación
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'google_id' => 'nullable|string|max:255', // Google ID puede ser nulo
            'password' => 'nullable|string|min:6',    // Contraseña puede ser nula
        ]);

        if ($validator->fails()) {
            Log::warning('Error de validación al crear usuario', ['errors' => $validator->errors()]);
            return response()->json($validator->errors(), 422);
        }

        // Creación del usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,  // Asignar google_id
            'password' => $request->password ? Hash::make($request->password) : null, // Hash de la contraseña si no es nula
        ]);

        Log::info('Usuario creado exitosamente', ['user' => $user]);
        return response()->json($user, 201); // 201 Created
    }

    public function update(Request $request, $id)
    {
        Log::info("Actualizando el usuario con ID: {$id}");

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'google_id' => 'nullable|string|max:255', // Google ID puede ser nulo
            'password' => 'nullable|string|min:6',    // Contraseña puede ser nula
        ]);

        // Preparar los datos para la actualización
        $dataToUpdate = $request->only(['name', 'email', 'google_id']);

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password); // Hash de la contraseña si se proporciona
        }

        $user->update($dataToUpdate);

        Log::info('Usuario actualizado exitosamente', ['user' => $user]);
        return response()->json($user, 200);
    }


    // Eliminar un usuario
    public function destroy($id)
    {
        Log::info("Eliminando el usuario con ID: {$id}");
        User::destroy($id);
        Log::info('Usuario eliminado exitosamente');
        return response()->json(null, 204);
    }
}
