<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Factura;

class FacturaController extends Controller
{
    //Gener una factua a partir de una cita.
    public function store(Cita $cita)
    {
        //Si ya existe factura para esta cita, no duplicamos.
        if($cita->factura){
            return redirect()
                ->route('admin.facturas.show', $cita->factura)
                ->with('success', 'La factura ya existía y se ha mostrado.');
        }

        //Sumamos el importe de los servicios asociados a la cita
        $baseImponible = $cita->servicios->sum(function ($servicio) {
            return $servicio->pivot->precio_aplicado;
        });

        $ivaPorcentaje = 21.00;
        $ivaImporte = round($baseImponible * ($ivaPorcentaje / 100), 2);
        $total = round($baseImponible + $ivaImporte, 2);

        //Generamos número de factura simple y único.
        $numeroFactura = 'FAC-' . now()->format('Ymd-His') . '-' . $cita->id;

        $factura = Factura::create([
            'cita_id' => $cita->id,
            'numero_factura' => $numeroFactura,
            'fecha_emision' => $cita->fecha_cita,
            'eatado_factura' => 'emitida',
            'base_imponible' => $baseImponible,
            'iva_porcentaje' => $ivaPorcentaje,
            'iva_importe' => $ivaImporte,
            'total' => $total,
        ]);

        return redirect()
            ->route('admin.facturas.show', $factura)
            ->with('success', 'Factura generada correctamente.');
    }

    //Mostrar una factura
    public function show(Factura $factura)
    {
        $factura->load('cita.user', 'cita.servicios', 'pagos');

        return view('admin.facturas.show', compact('factura'));
    }

    //Mostrar una versión imprimible de la factura.
    public function imprimir(Factura $factura)
    {
        $factura->load('cita.user', 'cita.servicios', 'pagos');

        return view('admin.facturas.imprimir', compact('factura'));
    }
}
