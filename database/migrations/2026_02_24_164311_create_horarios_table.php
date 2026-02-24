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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('dia_semana'); // Día de la semana (1=Lunes ... 7=Domingo)

            // Tramo de disponibilidad (ej: 09:00 - 14:00)
            $table->time('hora_inicio');
            $table->time('hora:fin');

            $table->boolean('activo')->default(true); // Permite desactivar tramos sin borrarlos
            $table->timestamps();

            $table->index(['dia_semana', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
