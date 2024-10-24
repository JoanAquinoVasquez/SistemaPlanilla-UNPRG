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
            'name' => 'JOAN EDINSON AQUINO VASQUEZ',
            'email' => 'jaquinov@unprg.edu.pe',
            'google_id' => '111386361494768820534', // Este debe ser un ID de Google válido
            'password' => bcrypt('password1'), // Contraseña cifrada
        ]);

        User::create([
            'name' => 'Juan David Chiscol Patazca',
            'email' => 'jchiscol@unprg.edu.pe',
            'google_id' => '107274766196539722579', // Este debe ser un ID de Google válido
            'password' => bcrypt('password2'), // Contraseña cifrada
        ]);

        // User::create([
        //     'name' => 'Usuario Tres',
        //     'email' => 'usuario3@example.com',
        //     'google_id' => 'google_id_3', // Este debe ser un ID de Google válido
        //     'password' => bcrypt('password3'), // Contraseña cifrada
        // ]);
    }
}
