<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //Campos asignables
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_servicio',
        'duracion_min',
        'precio',
        'activo',
    ];
    //Para que Laravel trate los tipos bien
    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'decimal:2',
        'duracion_min' => 'integer',
    ];

    //Un servicio puede aparecer en muchas citas.

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicio')
        ->withPivot('precio_aplicado')
        ->withTimestamps();
    }
}
