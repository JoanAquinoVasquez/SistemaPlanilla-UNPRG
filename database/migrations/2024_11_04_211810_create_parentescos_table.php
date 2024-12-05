<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parentescos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ejemplo: Padre, Hermano, Primo, etc.
            $table->enum('tipo', ['consanguinidad', 'afinidad']); // Indica si es consanguinidad o afinidad
            $table->string('nivel'); // Ejemplo: primer grado, segundo grado, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parentescos');
    }
};
