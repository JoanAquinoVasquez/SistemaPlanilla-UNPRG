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
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();
            // Clave foránea a 'empleado_tipos' para 'empleado_tipo_id'
            $table->foreignId('empleado_tipo_id')
                ->constrained('empleado_tipos', 'id_tipo_empleado')
                ->onDelete('cascade');

            // Clave foránea manual para 'empleado_tipo_num_doc_iden'
            $table->string('empleado_tipo_num_doc_iden', 20);
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
                ->onDelete('cascade');

            // Campos adicionales de la tabla vacaciones
            $table->boolean('estado')->default(1); // Usado booleano para activo/inactivo

            $table->integer('numero_dias');
            $table->date('periodo');
            $table->text('detalle')->nullable(); // Texto opcional para detalles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones');
    }
};
