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
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();

            $table->foreignId('tipo_empleado_id')
                ->constrained('tipo_empleados')
                ->onDelete('cascade');
            $table->boolean('estado')->default(1); // Estado activo/inactivo para eliminación lógica

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
