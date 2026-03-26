<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;

class CitaController extends Controller
{
    //Mostrar el formulario de edición de una cita.
    public function edit(Cita $cita)
    {
        //Servicios activos para poder cambiar el servicio de la cita
        $servicios = Servicio::where('activo',true)->orderBy('nombre')->get();

        //Horarios activos por si luego quieres usarlos en la edición
        $horarios = Horario::where('activo', true)
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();
        
        return view('admin.citas.edit', compact('cita', 'servicios','horarios'));
    }

    //Actualizar una cita desde el panel de administración
    public function update(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha_cita' => ['required', 'date'],
            'hora:inicio' => ['required'],
            'hora_fin' => ['required'],
            'estado' => ['required', 'in:pendiente,confirmada,cancelada'],
            'mensaje_cliente' => ['nullable', 'string'],
        ]);

        //Actualizamos los datos principales de la cita
        $cita->update([
            'fecha_cita' => $data['fecha_cita'],
            'hora:inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin'],
            'estado' => $data['estado'],
            'mensaje_cliente' => $data['mensaje_cliente'],            
        ]);

        //Actualizamos el servicio asociado en la tabla
        $precioAplicado = Servicio::findOrFail($data['servicio_id'])->precio;

        $cita->servicios()->sync([
            $data['servicio_id'] => [
                'precio_aplicado' =>$precioAplicado,
            ]
        ]);

        return redirect()
            ->route('admin.calendario.index')
            ->with('success', 'Cita actualizada correctamente.');
    }
}
