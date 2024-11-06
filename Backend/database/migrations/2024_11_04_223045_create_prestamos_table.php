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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_tipo_id');
            $table->unsignedBigInteger('empleado_tipo_num_doc_iden');
            $table->unsignedBigInteger('banco_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('monto_prestado', 8, 2); // Cambiado de numeric a decimal
            $table->decimal('monto_restante', 8, 2); // Cambiado de numeric a decimal
            $table->integer('numero_cuotas');
            $table->integer('estado');

            $table->foreign('empleado_tipo_id')
                ->references('id_tipo_empleado')
                ->on('empleado_tipos')
                ->onDelete('cascade');
            $table->foreign('empleado_tipo_num_doc_iden')
                ->references('num_doc_iden')
                ->on('empleado_tipos')
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
        Schema::dropIfExists('prestamos');
    }
};
