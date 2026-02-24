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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();

           
            $table->string('nombre', 80); // Nombre visible del servicio (ej: "Micropigmentación cejas")

            $table->text('descripcion')->nullable();  // Descripción opcional para la ficha del servicio

            $table->enum('tipo_servicio', ['micropigmentacion', 'maquillaje']); // Tipo de servicio: nos permitirá aplicar la regla "maquillaje profesional no se mezcla con micropigmentación"

            $table->unsignedSmallInteger('duracion_min');  // Duración estándar en minutos (la cita se ajusta según la suma de servicios)

            $table->decimal('precio', 8, 2);  // Precio del servicio en el catálogo

            $table->boolean('activo')->default(true); // Permite desactivar servicios sin borrarlos

            $table->timestamps();

            $table->index(['tipo_servicio', 'activo']); 

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
