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
            $table->string('tipo_doc', 30); // Tipo de documento (DNI, Pasaporte, etc.)
            $table->string('num_doc', 20); // Número de documento, clave primaria junto con tipo_doc            $table->string('nombres', 50);
            $table->string('nombres', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('telefono', 15)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('nivel_escolaridad', 50)->nullable();
            $table->boolean('dependiente')->default(false);
            $table->boolean('discapacidad')->default(false);
            $table->boolean('estado')->default(true);

            // Establecer clave primaria compuesta
            $table->primary(['tipo_doc', 'num_doc']);

            // Definir la columna antes de establecer la clave foránea
            $table->string('empleado_num_doc_iden', 20);
            $table->foreign('empleado_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleados')
                ->onDelete('cascade');

            $table->foreignId('parentesco_id')
                ->constrained('parentescos')
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
