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
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aportacions_id')->constrained()->onDelete('cascade');
            $table->foreignId('remuneracion_id')->constrained()->onDelete('cascade');
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

            // Campo de monto
            $table->decimal('monto', 10, 2);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ingresos');
    }
};
