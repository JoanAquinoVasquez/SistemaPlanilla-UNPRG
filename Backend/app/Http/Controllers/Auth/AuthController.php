<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Google_Client;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    // //
    // public function register(RegisterRequest $request)
    // {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'google_id' => $request->google_id
    //     ]);

    //     $token = JWTAuth::fromUser($user);
    //     return response()->json(compact('user', 'token'), 201);
    // }

    // public function login(LoginRequest $request)
    // {
    //     // Solo recibes el correo en la solicitud
    //     $credentials = $request->only('email');

    //     // Buscas el usuario en la base de datos por su email
    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user) {
    //         // Si no existe, devuelves un error de no autenticado
    //         return response()->json(['error' => 'Usuario no encontrado'], 404);
    //     }

    //     // Si existe el usuario, generas un token JWT
    //     $token = JWTAuth::fromUser($user);

    //     // Devuelves la información del usuario junto con el token
    //     return response()->json(compact('user', 'token'), 200);
    // }


    // Obtener todos los usuarios
    public function index()
    {
        // Log::info('Obteniendo todos los usuarios');
        return User::all();
    }

    // Obtener un usuario por ID
    public function show($id)
    {
        // Log::info("Obteniendo el usuario con ID: {$id}");
        return User::findOrFail($id);
    }

    public function store(RegisterRequest $request)
    {
        // Creación del usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,  // Asignar google_id
            'password' => $request->password ? Hash::make($request->password) : null, // Hash de la contraseña si no es nula
        ]);

        // Log::info('Usuario creado exitosamente', ['user' => $user]);
        return response()->json($user, 201); // 201 Created
    }

    public function update(RegisterRequest $request, $id)
    {
        // Log::info("Actualizando el usuario con ID: {$id}");

        $user = User::findOrFail($id);

        // Preparar los datos para la actualización
        $dataToUpdate = $request->only(['name', 'email', 'google_id']);

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password); // Hash de la contraseña si se proporciona
        }

        $user->update($dataToUpdate);

        // Log::info('Usuario actualizado exitosamente', ['user' => $user]);
        return response()->json($user, 200);
    }


    // Eliminar un usuario
    public function destroy($id)
    {
        // Log::info("Eliminando el usuario con ID: {$id}");
        User::destroy($id);
        // Log::info('Usuario eliminado exitosamente');
        return response()->json(null, 204);
    }

    public function googleLogin(Request $request)
    {
        $token_g = $request->input('token');

        // Inicializa el cliente de Google
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($token_g);

        if ($payload) {
            $googleId = $payload['sub'];
            $name = $payload['name'];
            $email = $payload['email'];
            $picture = $payload['picture']; // Obtiene la foto de perfil
            // $email = $payload['email'];
            // $name = $payload['name'];
            // Log::info($googleId);
            // Verifica si el usuario ya existe en la base de datos
            $user = User::where('email', $email)->first();

            if ($user) {
                // Si el usuario existe, actualiza su información
                $user->update([
                    'name' => $name,
                    'google_id' => $googleId,
                    'profile_picture' => $picture, // Actualiza la foto de perfil
                ]);

                // Genera el token JWT
                $jwtToken = JWTAuth::fromUser($user);
                $expiration = Carbon::now()->addMinutes(config('jwt.ttl'))->timestamp;

                // Devuelve el token JWT y el ID del usuario
                // Configura la cookie segura con el JWT
                $cookie = cookie('token', $jwtToken, config('jwt.ttl'), '/', null, true, true, false, 'Strict');
                Log::info([$user->id, $expiration]);
                return response()->json(['message' => 'Autenticado con éxito', 'user_id' => $user->id, 'expiration' => $expiration])
                    ->withCookie($cookie);
            } else {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
        } else {
            return response()->json(['error' => 'Token de Google inválido'], 401);
        }
    }


    public function logout()
    {
        // Invalida el token y elimina la cookie
        $cookie = Cookie::forget('token');

        return response()->json(['message' => 'Sesión cerrada'])
            ->withCookie($cookie);
    }


    public function checkAuth()
    {
        try {
            // Verifica si el token es válido
            JWTAuth::parseToken()->authenticate();
            return response()->json(['authenticated' => true]);
        } catch (\Exception $e) {
            return response()->json(['authenticated' => false], 401);
        }
    }

    public function refreshToken()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $newToken = JWTAuth::fromUser($user);
            $newExpiration = Carbon::now()->addMinutes(config('jwt.ttl'))->timestamp;

            // Configura la nueva cookie con el token renovado
            $cookie = cookie('token', $newToken, config('jwt.ttl'), '/', null, true, true, false, 'Strict');

            return response()->json(['message' => 'Token renovado', 'newToken' => $newToken, 'expiration' => $newExpiration])
                ->withCookie($cookie);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo renovar el token'], 401);
        }
    }

    // // Método para manejar el login desde el frontend con token de Google
    // public function handleGoogleCallback(Request $request)
    // {
    //     // Recibir el token de acceso desde el frontend
    //     $token = $request->input('token');

    //     // Verificar el token con Google
    //     $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);

    //     // Aquí puedes hacer lo necesario con el $googleUser
    //     Log::info($googleUser->all());

    //     // Buscar o crear el usuario en tu sistema
    //     $user = User::firstOrCreate(
    //         ['email' => $googleUser->getEmail()],
    //         ['name' => $googleUser->getName()]
    //     );

    //     // Generar token JWT o algún tipo de token para que el frontend lo use
    //     $token = $user->createToken('GoogleAuthToken')->plainTextToken;

    //     // Retornar el token al frontend
    //     return response()->json(['token' => $token]);
    // }
}
