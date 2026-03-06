<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    /**
     * Listado de servicios
     */
    public function index()
    {
        $servicios = Servicio::orderBy('tipo_servicio')
            ->orderBy('nombre')
            ->get();

        return view('admin.servicios.index', compact('servicios'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $servicio = new Servicio([
            'activo' => true,
            'tipo_servicio' => 'micropigmentacion',
        ]);

        return view ('admin.servicios.create', compact('servicio'));
    }

    /**
     * Guardar un servicio nuevo
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['activo'] = $request->has('activo');

        Servicio::create($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    /**
     * Actualizar servicio existente
     */
    public function update(Request $request, Servicio $servicio)
    {
        $data = $this->validatedData($request);
        $data['activo'] = $request->has('activo');

        $servicio->update($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Desactivar servicio
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->update(['activo' => false]);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio desactivado correctamente.');
    }

    /**
     * Validación centralizada
     */
    public function validatedData(Request $request) : array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string'],
            'tipo_servicio' => ['required', 'in:micropigmentacion,maquillaje'],
            'duracion_min' => ['required', 'integer', 'min:15', 'max:600'],
            'precio' => ['required', 'numeric', 'min:0', 'max:99999.99'],
        ]);
    }
}
