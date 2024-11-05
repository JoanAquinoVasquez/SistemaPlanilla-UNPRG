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
        Schema::create('sub_categoria_empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_empleado_id');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            
            $table->foreign('categoria_empleado_id')
                ->references('id')
                ->on('categoria_empleados')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categoria_empleados');
    }
};
