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
        Schema::create('cita_servicio', function (Blueprint $table) {
            $table->id();

            // Cita asociada
            $table->foreignId('cita_id')
                ->constrained('citas')
                ->cascadeOnDelete();
            
            // Servicio asociado
            $table->foreignId('servicio_id')
                ->constrained('servicios')
                ->restrictOnDelete();

            // Precio que se aplicó en el momento de reservar 
            // Esto permite que si el catálogo cambia, la cita/factura antigua no cambie.
            $table->decimal('precio_aplicado', 8, 2);

            $table->timestamps();

            $table->unique('cita_id', 'sercicio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita_servicio');
    }
};
