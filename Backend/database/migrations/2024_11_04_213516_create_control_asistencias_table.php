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
            // Clave foránea a 'empleado_tipos' usando 'foreignId' para 'empleado_tipo_id'
            $table->foreignId('empleado_tipo_id')
                ->constrained('empleado_tipos', 'id_tipo_empleado')
                ->onDelete('cascade');

            // Clave foránea manual para 'empleado_tipo_num_doc_iden'
            $table->string('empleado_tipo_num_doc_iden', 20);
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
                ->onDelete('cascade');

            $table->integer('numero_asistencias');
            $table->integer('numero_inasistencias');
            $table->integer('numero_tardanzas');
            $table->date('periodo');
            $table->integer('numero_permisos');
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
