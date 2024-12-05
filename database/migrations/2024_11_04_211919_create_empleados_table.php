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
        Schema::create('empleados', function (Blueprint $table) {
            $table->string('num_doc_iden')->primary();
            $table->string('nombres', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('tipo_doc_iden', 50);
            $table->date('fecha_nacimiento');
            $table->string('sexo', 50);
            $table->enum('estado_civil', ['Soltero', 'Casado', 'Viudo', 'Divorciado'])->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono', 15);
            $table->string('email')->unique();
            $table->integer('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
