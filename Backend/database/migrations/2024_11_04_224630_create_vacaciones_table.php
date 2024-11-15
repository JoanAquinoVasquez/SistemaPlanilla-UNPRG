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
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_tipo_id')->constrained()->onDelete('cascade');

            // Campos adicionales de la tabla vacaciones
            $table->boolean('estado')->default(true); // Usado booleano para activo/inactivo
            $table->integer('numero_dias');
            $table->date('periodo');
            $table->text('detalle')->nullable(); // Texto opcional para detalles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones');
    }
};
