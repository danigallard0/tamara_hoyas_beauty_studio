<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'user_id',
        'horario_id',
        'fecha_cita',
        'hora_inicio',
        'hora_fin',
        'estado',
        'mensaje_cliente',
    ];

    // La cita pertenece a un cliente.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //La cita pertenece a un horario base.
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    //Una cita puede incluir varios servicios.
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio')
        ->withPivot('precio_aplicado')
        ->withTimestamps();
    }

    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
