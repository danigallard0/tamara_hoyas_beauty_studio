<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;

class CalendarioController extends Controller
{
    //Muestra la vista del calendario del panel de admin
    public function index()
    {
        return view('admin.calendario.index');
    }

    //Devuelve las citas en formato JSON para FullCalendar
    public function eventos(Request $request)
    {
        //Empezamos la consulta cargando usuario y servicios
        $query = Cita::with(['user', 'servicios', 'factura.pagos']);

        //Filtrar por estado si viene informado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        //Filtrar por fecha exacta si viene informada
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_cita', $request->fecha);
        }

        $citas = $query->get();
        

        //Transformamos la cita al formato que FullCalendar espera
        $eventos = $citas->map(function($cita) {
            $nombreCliente = $cita->user?->name ?? 'Cliente';
            $servicios = $cita->servicios->pluck('nombre')->join(', ');
            $estadoCobro = $cita->factura ? $cita->factura->estado_cobro : 'pendiente';
             $titulo = $nombreCliente . ' - ' . $servicios . ' [' . strtoupper($estadoCobro) . ']';

            return [
                'id' => $cita->id,

                //Título que aparecera en el calendario
                'title' => $titulo,

                //Fecha y hora de inicio
                'start' => $cita->fecha_cita . 'T' . $cita->hora_inicio,

                //Fecha y hora de fin
                 'end' => $cita->fecha_cita . 'T' . $cita->hora_fin,

                 'allday' => false,

                 //Color según estado
                 'color' => match ($estadoCobro) {
                    'pendiente' => '#f59e0b',
                    'parcial' => '#f97316',
                    'pagado' => '#10b981',
                    default => '#3b82f6',
                 },

                 //Información extra por si queremos mostrar detalles
                 'extendedProps' => [
                    'estado' => $cita->estado,
                    'mensaje_cliente' => $cita->mensaje_cliente,
                    'estado_cobro' => $estadoCobro,
                 ],

            ];
        });

        return response()->json($eventos);
    }
}
