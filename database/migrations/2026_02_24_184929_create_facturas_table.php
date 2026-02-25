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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

             //una cita emite como máximo una factura
             $table->foreignId('cita_id')
                ->constrined('citas')
                ->cascadeOnDelete();
            
            // UNIQUE para forzar 1 factura por cita
            $table->unique('cita_id');

             // Número de factura
             $table->string('numero_factura', 30)->unique();

              // Fecha de emisión (normalmente el día de la cita)
              $table->date('fecha_emision');

              // Estado de factura (emitida/anulada).
              $table->enum('estado_factura' ,['emitida', 'anulada'])->default('emitida');

              // Importes calculados (dejamos guardados los totales para que la factura sea inmutable)
              $table->decimal('base_imponible', 10, 2);
              $table->decimal('iva_porcentaje', 5, 2)->default(21.00);
              $table->decimal('iva_importe', 10, 2);
              $table->decimal('total', 10, 2);

              $table->timestamps();

              $table->index(['fecha_emision', 'estado_factura']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
