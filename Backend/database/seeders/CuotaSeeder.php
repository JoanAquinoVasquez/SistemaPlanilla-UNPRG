<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuota;
use App\Models\Prestamo;
use Carbon\Carbon;

class CuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todos los préstamos
        $prestamos = Prestamo::all();

        // Crear cuotas para cada préstamo
        foreach ($prestamos as $prestamo) {
            for ($i = 1; $i <= $prestamo->numero_cuotas; $i++) {
                Cuota::create([
                    'prestamo_id' => $prestamo->id,
                    'fecha' => Carbon::now()->addMonths($i), // Simular cuotas mensuales
                    'monto' => round($prestamo->monto_prestado / $prestamo->numero_cuotas, 2), // Dividir el monto total entre el número de cuotas
                    'estado' => true,
                ]);
            }
        }
    }
}
