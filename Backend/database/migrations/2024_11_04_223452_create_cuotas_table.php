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
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la tabla prestamos
            $table->foreignId('prestamo_id')
                ->constrained()
                ->onDelete('cascade');


            $table->date('fecha');
            $table->decimal('monto', 10, 2);
            $table->boolean('estado')->default(1); // Cambiado a booleano si solo indica activo/inactivo


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
