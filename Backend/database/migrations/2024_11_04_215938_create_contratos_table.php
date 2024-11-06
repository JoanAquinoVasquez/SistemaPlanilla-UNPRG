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
            $table->unsignedBigInteger('empleado_tipo_id');
            $table->unsignedBigInteger('empleado_tipo_num_doc_iden');
            $table->decimal('sueldo_bruto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('estado');
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('regimen_laboral');
            $table->integer('horas_trabajo');
            
            $table->foreign('empleado_tipo_id')
                ->references('id_tipo_empleado')
                ->on('empleado_tipos')
                ->onDelete('cascade');
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
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
        Schema::dropIfExists('contratos');
    }
};
