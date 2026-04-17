<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'factura_id',
        'metodo',
        'importe',
        'estado',
        'fecha_pago',
        'referencia',
    ];

    //Un pago pertenece a una factura
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
