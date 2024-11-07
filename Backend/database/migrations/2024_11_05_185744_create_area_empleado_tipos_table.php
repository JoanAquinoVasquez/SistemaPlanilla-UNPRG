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
        Schema::create('area_empleado_tipos', function (Blueprint $table) {
            $table->id();
            // Claves foráneas para empleado_tipo_id y empleado_tipo_num_doc_iden
            $table->foreignId('empleado_tipo_id')
                ->constrained('empleado_tipos', 'id_tipo_empleado')
                ->onDelete('cascade');

            $table->string('empleado_tipo_num_doc_iden', 20);
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
                ->onDelete('cascade');

            $table->foreignId('area_id')->constrained()->onDelete('cascade'); // Clave foránea a 'formulas'
            $table->boolean('estado')->default(1); // Usar booleano para activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_empleado_tipos');
    }
};
