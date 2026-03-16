<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;
use Carbon\Carbon;


class CitaController extends Controller
{
    //Mostrar el formulario de creación de cita para el cliente.
    public function create()
    {
        //Solo mostramos servicios activos, ordenados por nombre
        $servicios = Servicio::where('activo', true)
        ->orderBy('nombre')
        ->get();

        //Solo mostramos horarios activos, ordenados por día y hora
        $horarios = Horario::where('activo', true)
        ->orderBy('dia_semana')
        ->orderBy('hora_inicio')
        ->get();

        return view('cliente.citas.create', compact('servicios', 'horarios'));
    }

    //Guardar una nueva cita creada por el cliente
    public function store(Request $request)
    {
        //Validación básica del formulario
        $data = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'horario_id' => ['required', 'exists:horarios,id'],
            'fecha_cita' => ['required', 'date'],
            'mensaje_cliente' => ['nullable', string],
        ]);

        //Buscamos el servicio y el horario seleccionados
        $servicio = Servicio::findOrFail($data['servicio_id']);
        $horario = Horario::findOrFail($data['horario_id']);

        //La hora de inicio de la cita será la hora de inicio del horario elegido
        $horaInicio = Carbon::createFromFormat('H:i:s', $horario->hora_inicio);

        //Calculamos la hora fin sumando la duración del servicio
        $horaFin = $horaInicio->copy()->addMinutes($servicio->duracion_min);

        //Creamos la cita con estado pendiente
        $cita = Cita::create([
            'user_id' => auth()->id(),
            'horario_id' => $horario->id,
            'fecha_cita' => $data['fecha_cita'],
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin' => $horaFin->format('H:i:s'),
            'estado' => 'pendiente',
            'mensaje_cliente' => $data['mensaje_cliente'] ?? null,
        ]);

        //Asociamos el servicio a a cita en la tabla intemedia
        $cita->servicios()->attach($servicio->id, [
            'precio_aplicado' => $servicio->precio,
        ]);

        return redirect()
            ->route('cliente.citas.create')
            ->with('success', 'Cita creada correctamente. Más adelante se confirmará con el pago del anticipo.');
    }
}
