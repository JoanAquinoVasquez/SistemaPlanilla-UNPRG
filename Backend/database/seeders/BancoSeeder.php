<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bancos = [
            ['nombre' => 'Banco de la Nación'],
            ['nombre' => 'BBVA'],
            ['nombre' => 'Interbank'],
            ['nombre' => 'BCP'],
            ['nombre' => 'Scotiabank'],
            ['nombre' => 'MiBanco'],
            ['nombre' => 'BanBif'],            
        ];
        
        foreach($bancos as $bancos){
            Banco::create($bancos);
        }
    }
}
