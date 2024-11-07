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
        Schema::create('remuneracions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planilla_id')->constrained()->onDelete('cascade');

            // Claves foráneas a 'empleado_tipos'
            $table->foreignId('empleado_tipo_id')
                ->constrained('empleado_tipos', 'id_tipo_empleado')
                ->onDelete('cascade');

            $table->string('empleado_tipo_num_doc_iden', 20);
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
                ->onDelete('cascade');

            // Campos de remuneración
            $table->decimal('sueldo_bruto', 10, 2);
            $table->decimal('total_ingreso', 10, 2);
            $table->decimal('total_egreso', 10, 2);
            $table->decimal('sueldo_aporte', 10, 2);
            $table->decimal('sueldo_neto', 10, 2);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remuneracions');
    }
};
