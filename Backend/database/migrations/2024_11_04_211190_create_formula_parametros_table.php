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
        Schema::create('formula_parametros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formula_id')->constrained()->onDelete('cascade'); // Clave foránea a 'formulas'
            $table->foreignId('parametro_id')->constrained()->onDelete('cascade'); // Clave foránea a 'parametros'
            $table->string('operacion', 255); // Campo adicional para definir la operación
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_parametros');
    }
};
