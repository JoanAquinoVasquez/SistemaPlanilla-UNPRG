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
            DocumentoSeeder::class,
            FormulaSeeder::class,
            ParametroSeeder::class,
            FormulaParametroSeeder::class,
            TipoEmpleadoSeeder::class,
            SubTipoEmpleadoSeeder::class,
            CategoriaEmpleadoSeeder::class,
            SubCategoriaEmpleadoSeeder::class,
            ParentescoSeeder::class,
            EmpleadoSeeder::class,
            DetalleFamiliaSeeder::class,
            BancoSeeder::class,
            EmpleadoTipoSeeder::class,
            ControlAsistenciaSeeder::class,
            ContratoSeeder::class,
            VacacionSeeder::class,
            LicenciaSeeder::class,
            AreaSeeder::class,
            AreaEmpleadoTipoSeeder::class,
            EgresoSeeder::class,
            IngresoSeeder::class,
            AportacionSeeder::class,
       
            PrestamoSeeder::class,
            DocumentoSeeder::class,
            CuotaSeeder::class,
            PlanillaSeeder::class,
            RemuneracionSeeder::class,
            DetalleAportacionSeeder::class,
            DetalleEgresoSeeder::class,
            DetalleIngresoSeeder::class,
        ]);
    }
}
