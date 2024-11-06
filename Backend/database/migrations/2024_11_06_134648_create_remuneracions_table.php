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
            $table->unsignedBigInteger('empleado_tipo_id');
            $table->unsignedBigInteger('empleado_tipo_num_doc_iden');
            $table->decimal('sueldo_bruto', 8, 2);
            $table->decimal('total_ingreso', 8, 2);
            $table->decimal('total_egreso', 8, 2);
            $table->decimal('sueldo_aporte', 8, 2);
            $table->decimal('sueldo_neto', 8, 2);

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
        Schema::dropIfExists('remuneracions');
    }
};
