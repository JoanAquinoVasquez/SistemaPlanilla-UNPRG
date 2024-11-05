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
        Schema::create('detalle_familias', function (Blueprint $table) {
            $table->id('dni');
            $table->unsignedBigInteger('empleado_dni');
            $table->unsignedBigInteger('parentesco_id');
            $table->string('nombres', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('telefono', 12);
            $table->date('fecha_nacimiento');
            $table->string('nivel_escolaridad');
            $table->string('dependiente');
            $table->string('discapacidad');
            $table->integer('estado');

            $table->foreign('empleado_dni')
                ->references('dni')
                ->on('empleados')
                ->onDelete('cascade');
            $table->foreign('parentesco_id')
                ->references('id')
                ->on('parentescos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_familias');
    }
};
