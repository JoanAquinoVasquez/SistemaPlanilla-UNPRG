<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Planilla;
use App\Models\User;
use Carbon\Carbon;

class PlanillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all(); // Verifica la existencia de usuarios

        $planillas = [
            [
                'fecha_inicio' => Carbon::now()->startOfMonth(),
                'fecha_fin' => Carbon::now()->endOfMonth(),
                'fecha_generacion' => Carbon::now(),
                'estado' => 1, // Estado activo
            ],
            [
                'fecha_inicio' => Carbon::now()->subMonth()->startOfMonth(),
                'fecha_fin' => Carbon::now()->subMonth()->endOfMonth(),
                'fecha_generacion' => Carbon::now()->subMonth()->endOfMonth(),
                'estado' => 1, // Estado activo
            ],
            [
                'fecha_inicio' => Carbon::now()->subMonths(2)->startOfMonth(),
                'fecha_fin' => Carbon::now()->subMonths(2)->endOfMonth(),
                'fecha_generacion' => Carbon::now()->subMonths(2)->endOfMonth(),
                'estado' => 0, // Estado inactivo
            ],
        ];

        foreach ($planillas as $planillaData) {
            // Asigna un `user_id` aleatorio de la lista de usuarios
            $planillaData['user_id'] = $users->random()->id;
            Planilla::create($planillaData);
        }
    }
}
