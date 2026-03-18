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


        return view('cliente.citas.create', compact('servicios'));
    }

    //Horas disponibles para poder reservar un servicio
    public function horasDisponibles(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha_cita' => ['required', 'date'],
        ]);

        $servicio = Servicio::findOrFail($data['servicio_id']);
        $fecha = Carbon::parse($data['fecha_cita']);
        $diaSemana = $fecha->dayOfWeekIso; // 1=Lunes ... 7=Domingo

        $horarios = Horario::where('activo', true)
            ->where('dia_semana', $diaSemana)
            ->orderBy('hora_inicio')
            ->get();

        $citasExistentes = Cita::where('fecha_cita', $data['fecha_cita'])
            ->where('estado', '!=', 'cancelada')
            ->get();

        $horasDisponibles = [];

        foreach ($horarios as $horario) {
            $inicioBloque = Carbon::createFromFormat('H:i:s', $horario->hora_inicio);
            $finBloque = Carbon::createFromFormat('H:i:s', $horario->hora_fin);

            $slotInicio = $inicioBloque->copy();

            while ($slotInicio->copy()->addMinutes($servicio->duracion_min)->lte($finBloque)) {
                $slotFin = $slotInicio->copy()->addMinutes($servicio->duracion_min);

                $solapa = $citasExistentes->contains(function ($cita) use ($slotInicio, $slotFin) {
                $citaInicio = Carbon::createFromFormat('H:i:s', $cita->hora_inicio);
                $citaFin = Carbon::createFromFormat('H:i:s', $cita->hora_fin);

                    return $citaInicio < $slotFin && $citaFin > $slotInicio;
                });

                if (! $solapa) {
                    $horasDisponibles[] = [
                        'value' => $slotInicio->format('H:i:s'),
                        'label' => $slotInicio->format('H:i') . ' - ' . $slotFin->format('H:i'),
                    ];
                }

                $slotInicio->addMinutes(30);
             }
         }

         return response()->json($horasDisponibles);
    }

    //Guardar una nueva cita creada por el cliente
   public function store(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha_cita' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i:s'],
            'mensaje_cliente' => ['nullable', 'string'],
        ]);

        $servicio = Servicio::findOrFail($data['servicio_id']);
        $fecha = Carbon::parse($data['fecha_cita']);
        $diaSemana = $fecha->dayOfWeekIso;

        $horaInicio = Carbon::createFromFormat('H:i:s', $data['hora_inicio']);
        $horaFin = $horaInicio->copy()->addMinutes($servicio->duracion_min);

        $horario = Horario::where('activo', true)
            ->where('dia_semana', $diaSemana)
            ->where('hora_inicio', '<=', $horaInicio->format('H:i:s'))
            ->where('hora_fin', '>=', $horaFin->format('H:i:s'))
            ->first();

        if (! $horario) {
            return back()
                ->withErrors(['hora_inicio' => 'La hora seleccionada no encaja en ningún horario disponible.'])
                ->withInput();
        }

        $existeSolape = Cita::where('fecha_cita', $data['fecha_cita'])
            ->where('estado', '!=', 'cancelada')
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where('hora_inicio', '<', $horaFin->format('H:i:s'))
                    ->where('hora_fin', '>', $horaInicio->format('H:i:s'));
             })
            ->exists();

        if ($existeSolape) {
            return back()
                ->withErrors(['hora_inicio' => 'Ya existe una cita en ese horario.'])
                ->withInput();
        }

        $cita = Cita::create([
            'user_id' => auth()->id(),
            'horario_id' => $horario->id,
            'fecha_cita' => $data['fecha_cita'],
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin' => $horaFin->format('H:i:s'),
            'estado' => 'pendiente',
            'mensaje_cliente' => $data['mensaje_cliente'] ?? null,
        ]);

        $cita->servicios()->attach($servicio->id, [
            'precio_aplicado' => $servicio->precio,
        ]);

        return redirect()
            ->route('cliente.citas.index')
            ->with('success', 'Cita creada correctamente.');
    }

    //Mostrar las citas del cliente autenticado
    public function index()
    {
        $citas = Cita::with('servicios')
            ->where('user_id', auth()->id())
            ->orderBy('fecha_cita', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('cliente.citas.index', compact('citas'));
    }

    //Cancelar una cita del cliente
    public function destroy(Cita $cita)
    {
        //Impedir cancelar cita de otro usuario
        if ($cita->user_id !== auth()->id()){
            abort(403);
        }

        $cita->update(['estado' => 'cancelada']);

        return redirect()
            ->route('cliente.citas.index')
            ->with('success', 'Cita cancelada correctamente.');
    }
}
