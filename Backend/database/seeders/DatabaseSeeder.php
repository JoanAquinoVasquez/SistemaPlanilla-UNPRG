<?php

namespace Database\Seeders;

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
        $this->call([FormulaSeeder::class, UsersTableSeeder::class, DocumentoSeeder::class, ParametroSeeder::class,FormulaParametroSeeder::class]);
    }
}
