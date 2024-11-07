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
            // Claves foráneas para empleado_tipos
            $table->foreignId('empleado_tipo_id')
                ->constrained('empleado_tipos', 'id_tipo_empleado')
                ->onDelete('cascade');

            $table->string('empleado_tipo_num_doc_iden', 20);
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
                ->onDelete('cascade');

            $table->decimal('sueldo_bruto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('estado')->default(1); // Usar booleano para activo/inactivo
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 20);
            $table->string('regimen_laboral', 50);
            $table->integer('horas_trabajo');

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
