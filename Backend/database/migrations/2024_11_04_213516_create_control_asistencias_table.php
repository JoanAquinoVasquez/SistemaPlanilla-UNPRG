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
            $table->unsignedBigInteger('empleado_tipo_id');
            $table->unsignedBigInteger('empleado_tipo_dni');
            $table->integer('numero_asistencias');
            $table->integer('numero_inaasistencias');
            $table->integer('numero_tardanzas');
            $table->integer('periodo');
            $table->integer('numero_permisos'); 

            $table->foreign('empleado_tipo_id')
                ->references('id')
                ->on('empleado_tipos')
                ->onDelete('cascade');
            $table->foreign('empleado_tipo_dni')
                ->references('dni')
                ->on('empleado_tipos')
                ->onDelete('cascade');

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
