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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            // Una factura puede tener varios pagos (anticipo + resto, etc.)
            $table->foreignId('factura_id')
                ->constrained('facturas')
                ->cascadeOnDelete();
            
            // Método de pago
            $table->enum('metodo', ['efectivo', 'tarjeta', 'bizum', 'transferencia']);

            // Importe del pago (por ejemplo anticipo del 20%)
            $table->decimal('importe', 10, 2);

            // Estado del pago
            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente');

            // Fecha/hora real del pago
            $table->dateTime('fecha_pago')->nullable();

            // Referencia de la operación
            $table->string('referencia', 100)->nullable();

            $table->timestamps();

            $table->index(['estado', 'metodo']);
            $table->index(['factura_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
