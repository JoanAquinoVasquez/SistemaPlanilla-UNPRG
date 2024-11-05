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
        Schema::create('empleado_tipos', function (Blueprint $table) {
            $table->unsignedBigInteger('id'); //PK
            $table->unsignedBigInteger('dni'); //FK como PK

            $table->unsignedBigInteger('banco_id'); //FK
            $table->integer('tipo_cuenta');
            $table->integer('cci');
            $table->unsignedBigInteger('numero_cuenta');

            // Clave primaria compuesta (dni, codigo)
            $table->primary(['id', 'dni']);
            
            $table->foreign('dni')
                ->references('dni')
                ->on('empleados')
                ->onDelete('cascade');
            $table->foreign('banco_id')
                ->references('id')
                ->on('bancos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_tipos');
    }
};
