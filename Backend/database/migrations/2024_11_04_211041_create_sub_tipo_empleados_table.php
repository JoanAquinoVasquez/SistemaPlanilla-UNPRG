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
        Schema::create('sub_tipo_empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_empleado_id');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            
            $table->foreign('tipo_empleado_id')
                ->references('id')
                ->on('tipo_empleados')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tipo_empleados');
    }
};
