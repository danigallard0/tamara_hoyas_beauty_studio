<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;
use App\Models\Factura;
use App\Models\Pago;
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
            'hora_inicio' => ['required'],
            'mensaje_cliente' => ['nullable', 'string'],
        ]);

        $servicio = Servicio::findOrFail($data['servicio_id']);

        //Si el servicio es maquillaje -> mensaje obligatorio
        if ($servicio->tipo_servicio === 'maquillaje' && empty($data['mensaje_cliente'])) {
            return back()
                ->withErrors([
                    'mensaje_cliente' => 'Debes indicar observaciones para servicios de maquillaje.'
                ])
                ->withInput();
        }
        
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

        //Creamos automáticamente la factura asociada a la cita
        $baseImponible = $servicio->precio;
        $ivaPorcentaje = 21.00;
        $ivaImporte = round($baseImponible * $ivaPorcentaje / 100, 2);
        $total = round($baseImponible + $ivaImporte, 2);

        $factura = Factura::create([
            'cita_id' => $cita->id,
            'numero_factura' => 'FAC-' . now()->format('Ymd-His') . '-' . $cita->id,
            'fecha_emision' => $cita->fecha_cita,
            'estado_factura' => 'emitida',
            'base_imponible' => $baseImponible,
            'iva_porcentaje' => $ivaPorcentaje,
            'iva_importe' => $ivaImporte,
            'total' => $total,
        ]);

        return redirect()
            ->route('cliente.citas.pago', $cita)
            ->with('success', 'Cita creada. Para confirmar la reserva debes pagar el 20% del servicio.');
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

    //Modificar una cita por el administrador
    public function update(Request $request, Cita $cita)
{
    $data = $request->validate([
        'servicio_id' => ['required', 'exists:servicios,id'],
        'fecha_cita' => ['required', 'date'],
        'hora_inicio' => ['required'],
        'hora_fin' => ['required'],
        'estado' => ['required'],
        'mensaje_cliente' => ['nullable', 'string'],
    ]);

    // Actualizamos datos principales
    $cita->update([
        'fecha_cita' => $data['fecha_cita'],
        'hora_inicio' => $data['hora_inicio'],
        'hora_fin' => $data['hora_fin'],
        'estado' => $data['estado'],
        'mensaje_cliente' => $data['mensaje_cliente'],
    ]);

    // Actualizamos servicio
    $cita->servicios()->sync([
        $data['servicio_id'] => [
            'precio_aplicado' => $cita->servicios->first()->pivot->precio_aplicado ?? 0
        ]
    ]);

    return redirect()->route('admin.calendario.index')
        ->with('success', 'Cita actualizada correctamente');
}

    //Muestra la pantalla de pago simulado del 20% para confirmar la cita.
    public function pago(Cita $cita)
    {
        //Seguridad: solo el dueño de la cita puede pagarla
        if ($cita->user_id !== auth()->id()) {
            abort(403);
        }

        if ($cita->estado === 'confirmada') {
            return redirect()
                ->route('cliente.citas.index')
                ->with('error', 'Esta cita ya está confirmada.'); 
        }

        //Cargamos la factura y servicios por comodidad
        $cita->load('factura', 'servicios');

        if(! $cita->factura){
            return redirect()
                ->route('cliente.citas.index')
                ->with('error', 'La cita no tiene factura asociada.');
        }

        //Anticipo del 20% sobre la base imponible
        $anticipo = round($cita->factura->base_imponible * 0.20, 2);

        return view('cliente.citas.pago', compact('cita', 'anticipo'));
    }

    //Procesa el pago simulado del 20% de la cita.
    public function procesarPago(Request $request, Cita $cita)
    {
        //Seguridad: solo el dueño de la cita puede pagarla
        if($cita->user_id !== auth()->id()){
            abort(403);
        }

        $cita->load('factura');

        if(! $cita->factura){
            return redirect()
                ->route('cliente.citas.index')
                ->with('error', 'La cita no tiene factura asociada.');
        }

        $data = $request->validate([
            'metodo' => ['required', 'in:tarjeta,bizum,transferencia'],
        ]);

        //Calculamos el anticipo del 20%
        $anticipo = round($cita->factura->base_imponible * 0.20, 2);

        $anticipoYaPagado = $cita->factura->pagos()
            ->where('estado', 'pagado')
            ->where('referencia', 'like', 'SIM-%-' . $cita->id)
            ->exists();

        if ($anticipoYaPagado) {
            return redirect()
                ->route('cliente.citas.index')
                ->with('error', 'Esta reserva ya tiene el anticipo pagado.');
        }

        //Registramos el pago simulado
        Pago::create([
            'factura_id' => $cita->factura->id,
            'metodo' => $data['metodo'],
            'importe' => $anticipo,
            'estado' => 'pagado',
            'fecha_pago' => now(),
            'referencia' => 'SIM-' . now()->format('YmdHis') . '-' . $cita->id,
        ]);

        //Marcamos la cita como confirmada tras el pago del anticipo
        $cita->update([
            'estado' => 'confirmada',
        ]);

        return redirect()
            ->route('cliente.citas.index')
            ->with('success', 'Tu reserva ha sido confirmada perfectamente.');
    }

    public function fechasDisponibles(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
        ]);

        $servicio = Servicio::findOrFail($data['servicio_id']);
        $fechasDisponibles = [];

        // Revisamos los próximos 30 días
        for ($i = 0; $i < 30; $i++) {
            $fecha = now()->addDays($i)->startOfDay();
            $diaSemana = $fecha->dayOfWeekIso; // 1=Lunes ... 7=Domingo

            $horarios = Horario::where('activo', true)
                ->where('dia_semana', $diaSemana)
                ->orderBy('hora_inicio')
                ->get();

            // Si no hay horario ese día, lo saltamos
            if ($horarios->isEmpty()) {
                continue;
            }

            $citasExistentes = Cita::whereDate('fecha_cita', $fecha->format('Y-m-d'))
                ->where('estado', '!=', 'cancelada')
                ->get();

            $hayHueco = false;

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
                        $hayHueco = true;
                        break 2; // salimos del while y del foreach
                    }

                    $slotInicio->addMinutes(30);
                }
            }

            if ($hayHueco) {
                $fechasDisponibles[] = [
                    'start' => $fecha->format('Y-m-d'),
                    'display' => 'background',
                    'color' => '#fce7f3',
                ];
            }
        }

        return response()->json($fechasDisponibles);
    }
    
}
