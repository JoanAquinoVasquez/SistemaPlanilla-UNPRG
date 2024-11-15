<?php

namespace Database\Seeders;

use App\Models\Aportacion;
use App\Models\AreaEmpleadoTipo;
use App\Models\EmpleadoTipo;
use App\Models\Parentesco;
use App\Models\User;
use Google\Service\CloudNaturalLanguage\Document;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            EmpleadoSeeder::class,
            DocumentoSeeder::class,
            BancoSeeder::class,
            FormulaSeeder::class,
            AreaSeeder::class,
            TipoEmpleadoSeeder::class,

            ParametroSeeder::class,
            FormulaParametroSeeder::class,

            SubTipoEmpleadoSeeder::class,
            CategoriaEmpleadoSeeder::class,
            SubCategoriaEmpleadoSeeder::class,

            ParentescoSeeder::class,            
            DetalleFamiliaSeeder::class,

            EgresoSeeder::class,
            IngresoSeeder::class,
            AportacionSeeder::class,

            EmpleadoTipoSeeder::class,
            AreaEmpleadoTipoSeeder::class,

            ContratoSeeder::class,
            ControlAsistenciaSeeder::class,            
            VacacionSeeder::class,
            LicenciaSeeder::class,

            PrestamoSeeder::class,
            CuotaSeeder::class,
                        
            PlanillaSeeder::class,
            RemuneracionSeeder::class,
            
            DetalleAportacionSeeder::class,
            DetalleEgresoSeeder::class,
            DetalleIngresoSeeder::class,
        ]);
    }
}
