<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo User

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Crear usuarios
        User::create([
            'email' => 'jaquinov@unprg.edu.pe',
        ]);

        User::create([
            'email' => 'jchiscol@unprg.edu.pe',
        ]);

        // User::create([
        //     'name' => 'Usuario Tres',
        //     'email' => 'usuario3@example.com',
        //     'google_id' => 'google_id_3', // Este debe ser un ID de Google válido
        //     'password' => bcrypt('password3'), // Contraseña cifrada
        // ]);
    }
}
