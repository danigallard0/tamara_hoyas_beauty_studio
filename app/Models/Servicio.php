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
    //Para que Laraveltrate los tipos bien
    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'decimal:2',
        'duracion_min' => 'integer',
    ];
}
