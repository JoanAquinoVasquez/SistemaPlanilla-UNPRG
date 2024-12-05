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
            $table->id();
            
            $table->string('empleado_num_doc_iden', 20);
            $table->foreignId('tipo_empleado_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_tipo_empleado_id')->constrained()->onDelete('cascade');
            $table->foreignId('categoria_empleado_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sub_categoria_empleado_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('banco_id')->constrained()->onDelete('cascade');

            $table->string('tipo_cuenta', 50)->comment('Tipos posibles: ahorros, corriente, plazo_fijo, sueldo, cts');
            $table->string('cci', 20);
            $table->string('numero_cuenta', 20);
            $table->boolean('estado')->default(true);

            // Agregar la restricción de clave foránea manualmente
            $table->foreign('empleado_num_doc_iden')->references('num_doc_iden')->on('empleados')->onDelete('cascade');

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
