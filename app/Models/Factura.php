<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //Campos que se pueden asignar en masa 
    protected $fillable = [
        'cita_id',
        'numero_factura',
        'fecha_emision',
        'estado_factura',
        'base_imponible',
        'iva_porcentaje',
        'iva_importe',
        'total',
    ];

    //Relación: una factura pertenece a una cita

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    //Relación: Una factura puede tener varios pagos.

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    //Calcula cuanto se ha pagado en total para esta factura.
    public function getTotalPagadoAttribute()
    {
        return $this->pagos()
            ->where('estado', 'pagado')
            ->sum('importe');
    }

    //Devuelve estado de cobro de la factura: Pendiente, Parcial, Pagado.
    public function getEstadoCobroAttribute()
    {
        $totalPagado = $this->total_pagado;

        if($totalPagado <= 0) {
            return 'pendiente';
        }

        if($totalPagado < $this->total) {
            return 'parcial';
        }

        return 'pagado';
    }
}
