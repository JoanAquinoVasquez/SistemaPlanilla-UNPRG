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
            $table->unsignedBigInteger('id_tipo_empleado'); //FK como PK
            $table->unsignedBigInteger('num_doc_iden'); //FK como PK

            $table->unsignedBigInteger('banco_id'); //FK
            $table->integer('tipo_cuenta');
            $table->integer('cci');
            $table->unsignedBigInteger('numero_cuenta');

            // Clave primaria compuesta (dni, codigo)
            $table->primary(['id_tipo_empleado', 'num_doc_iden']);
            
            $table->foreign('id_tipo_empleado')
                ->references('id')
                ->on('tipo_empleados')
                ->onDelete('cascade');

            $table->foreign('num_doc_iden')
                ->references('num_doc_iden')
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
