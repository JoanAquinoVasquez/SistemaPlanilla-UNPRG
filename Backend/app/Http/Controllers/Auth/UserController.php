<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Listar usuarios
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Mostrar un usuario
    public function show($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        
        return response()->json($user);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encriptar la contraseña
        ]);

        return response()->json($user, 201);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Actualizar los datos del usuario
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json($user);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }
}
