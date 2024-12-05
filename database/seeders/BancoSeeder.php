<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banco;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $bancos = [
            ['nombre' => 'Banco de la Nación', 'descripcion' => 'Banco principal del sector público en Perú'],
            ['nombre' => 'Banco de Crédito del Perú (BCP)', 'descripcion' => 'Banco líder en servicios financieros'],
            ['nombre' => 'Interbank', 'descripcion' => 'Banco con fuerte presencia en comercio digital'],
            ['nombre' => 'BBVA Perú', 'descripcion' => 'Banco con sede en Europa y amplia cobertura en Perú'],
            ['nombre' => 'Scotiabank', 'descripcion' => 'Banco de origen canadiense con presencia en Perú'],
            ['nombre' => 'BanBif', 'descripcion' => 'Banco especializado en servicios de crédito personal'],
            ['nombre' => 'MiBanco', 'descripcion' => 'Banco especializado en microfinanzas y pequeñas empresas'],
        ];

        foreach ($bancos as $banco) {
            Banco::create($banco);
        }
    }
}
