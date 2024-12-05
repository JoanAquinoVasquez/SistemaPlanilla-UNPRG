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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_tipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('banco_id')->constrained()->onDelete('cascade');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('monto_prestado', 10, 2); // Cambiado de numeric a decimal
            $table->decimal('monto_restante', 10, 2); // Cambiado de numeric a decimal
            $table->integer('numero_cuotas');
            $table->boolean('estado')->default(true); // Estado activo/inactivo como booleano

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
