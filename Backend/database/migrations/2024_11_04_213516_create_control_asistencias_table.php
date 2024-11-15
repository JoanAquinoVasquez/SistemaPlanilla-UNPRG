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
        Schema::create('control_asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_tipo_id')->constrained()->onDelete('cascade');
            
            $table->integer('numero_asistencias');
            $table->integer('numero_inasistencias');
            $table->integer('numero_tardanzas');
            $table->date('periodo');
            $table->integer('numero_permisos');
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_asistencias');
    }
};
