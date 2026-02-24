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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();

            // Usuario que realiza la reserva (cliente)
            $table->foreingId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            
                // Horario base (tramo de disponibilidad) donde cae la cita
            // Usamos restrictOnDelete para evitar borrar un horario si tiene citas asociadas
            $table->foreingId('horario_id')
                ->constrained('horarios')
                ->restrictOnDelete();
            
            // Fecha y horas de la cita
            $table->date('fecha_cita');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Estado de la cita
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])
                ->default('pendiente');
            
            // Mensaje/observaciones del cliente.
            // (Para maquillaje profesional aquí guardaremos: boda, evento, etc.)
            $table->text('mensaje_cliente')->nullable();
           
            $table->timestamps();

             // Índices útiles para consultas del calendario y filtros
            $table->index(['fecha_cita', 'estado']);
            $table->index(['user_id', 'fecha_cita']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
