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
            $table->unsignedBigInteger('empleado_tipo_id');
            $table->unsignedBigInteger('empleado_tipo_num_doc_iden');
            $table->foreignId('area_id')->constrained()->onDelete('cascade'); // Clave foránea a 'formulas'
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
        Schema::dropIfExists('area_empleado_tipos');
    }
};
