<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = Horario::orderBy('dia_semana')->get();

        return view('admin.horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $horario = new Horario();

        return view('admin.horarios.create', compact('horario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dia_semana' => 'required|integer|min:0|max:6',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $data['activo'] = $request->has('activo');

        Horario::create($data);

        return redirect()
            ->route('admin.horarios.index')
            ->with('success', 'Horario creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        return view('admin.horarios.edit', compact('horario'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $data = $request->validate([
            'dia_semana' => 'required|integer|min:0|max:6',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required!date_format:H:i!after:hora_inicio',
        ]);

        $data['activo'] = $request->has('activo');

        $horario->update($data);

        return redirect()
            ->route('admin.horarios.index')
            ->with('success', 'Horario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()
            ->route('admin.horarios.index')
            ->with('success', 'Horario eliminado');
    }
}
