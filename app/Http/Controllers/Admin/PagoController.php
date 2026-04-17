<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    //Registrar un pago asociado a una factura.
    public function store (Request $request, Factura $factura)
    {
        $data = $request->validate([
            'metodo' => ['required', 'in:efectivo,tarjeta,bizum,transferencia'],
            'importe' => ['required', 'numeric', 'min:0.01'],
            'referencia' => ['nullable', 'string', 'max:100'],
        ]);

        // Total ya pagado de esa factura
        $totalPagado = $factura->pagos()
            ->where('estado', 'pagado')
            ->sum('importe');

        // Lo que queda pendiente de pagar
        $pendiente = round($factura->total - $totalPagado, 2);

        // Si ya está totalmente pagada, no permitimos más pagos
        if ($pendiente <= 0) {
            return redirect()
                ->route('admin.facturas.show', $factura)
                ->with('error', 'La factura ya está completamente pagada.');
        }

        // No permitimos registrar un pago superior a lo pendiente
        if ($data['importe'] > $pendiente) {
            return redirect()
                ->route('admin.facturas.show', $factura)
                ->withErrors([
                    'importe' => 'El importe no puede superar lo pendiente de pago (' . number_format($pendiente, 2) . ' €).'
                ])
                ->withInput();
        }

        Pago::create([
            'factura_id' => $factura->id,
            'metodo' => $data['metodo'],
            'importe' => $data['importe'],
            'estado' => 'pagado',
            'fecha_pago' => now(),
            'referencia' => $data['referencia'] ?? null,
        ]);

        return redirect()
            ->route('admin.facturas.show', $factura)
            ->with('success', 'Pago registrado correctamente.');
    }
}
