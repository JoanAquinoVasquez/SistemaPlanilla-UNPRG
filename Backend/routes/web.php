<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\UserController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

// Callback para manejar la respuesta de Google
Route::get('/google-auth/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Aquí puedes encontrar o crear el usuario en tu base de datos
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // Si el usuario no existe, crea uno nuevo
        $user = User::updateOrCreate([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
        ]);
    }

    // Inicia sesión al usuario
    Auth::login($user);

    // Redirige a la aplicación frontend después de iniciar sesión
    return redirect('http://localhost:5173/Inicio'); // Ajusta la URL según tu aplicación React
});
