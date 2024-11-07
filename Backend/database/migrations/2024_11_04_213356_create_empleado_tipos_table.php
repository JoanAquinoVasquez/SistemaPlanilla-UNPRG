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
            $table->foreignId('id_tipo_empleado')
                ->constrained('tipo_empleados')
                ->onDelete('cascade'); // FK y parte de la PK
            $table->string('num_doc_iden', 20); // Cambiado a string para coincidir con el tipo en 'empleados' y parte de la PK

            $table->foreignId('banco_id')
                ->constrained('bancos')
                ->onDelete('cascade'); // FK a la tabla bancos
            $table->string('tipo_cuenta', 50)->comment('Tipos posibles: ahorros, corriente, plazo_fijo, sueldo, cts');
            $table->string('cci', 20); // CCI como cadena alfanumérica
            $table->string('numero_cuenta', 20); // Número de cuenta como cadena para soportar valores con ceros iniciales
            // Clave primaria compuesta (dni, codigo)
            $table->primary(['id_tipo_empleado', 'num_doc_iden']);

            $table->foreign('num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleados')
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
