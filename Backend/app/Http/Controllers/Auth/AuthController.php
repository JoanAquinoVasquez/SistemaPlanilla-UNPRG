<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'google_id' => $request->google_id
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(LoginRequest $request)
    {
        // Solo recibes el correo en la solicitud
        $credentials = $request->only('email');

        // Buscas el usuario en la base de datos por su email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Si no existe, devuelves un error de no autenticado
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Si existe el usuario, generas un token JWT
        $token = JWTAuth::fromUser($user);

        // Devuelves la información del usuario junto con el token
        return response()->json(compact('user', 'token'), 200);
    }


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

    public function store(RegisterRequest $request)
    {
        Log::info('Creando un nuevo usuario', ['data' => $request->all()]);

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

    public function update(RegisterRequest $request, $id)
    {
        Log::info("Actualizando el usuario con ID: {$id}");

        $user = User::findOrFail($id);

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
