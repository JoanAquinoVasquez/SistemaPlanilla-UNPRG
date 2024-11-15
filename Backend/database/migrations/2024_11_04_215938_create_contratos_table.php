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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_tipo_id')->constrained()->onDelete('cascade');

            $table->decimal('sueldo_bruto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 20);
            $table->string('regimen_laboral', 50);
            $table->integer('horas_trabajo');
            $table->boolean('estado')->default(true); // Usar booleano para activo/inactivo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
