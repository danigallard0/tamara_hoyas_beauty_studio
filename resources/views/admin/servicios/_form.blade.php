

{{-- Formulario reutilizable pare create/edit --}}
<div class="space-y-4">

  <div>
    <label class="block font-medium">Nombre</label>
   <input name="nombre" class="w-full border rounded p-2" 
    value="{{old('nombre', $servicio->nombre) }}" required> 
    @error('nombre') <p class="text-red-600 text-sm">{{ $message }}</p> 
    @enderror
  </div>

  <div>
    <label class="block font-medium">Descripción</label>
    <textarea name="descripcion" class="w-full border rounded p-2" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
    @error('descripcion') <p class="text-red-600 text-sm">{{ $message }}</p> 
    @enderror
  </div>

  <div>
    <label class="block font-medium">Tipo de servicio</label>
    @php $tipo = old('tipo_servicio', $servicio->tipo_servicio); @endphp
    <select name="tipo_servicio" class="w-full border rounded p-2" required> 
      <option value="micropigmentacion" @selected($tipo === 'micropigmentacion')>Micropigmentación</option>
      <option value="maquillaje" @selected($tipo === 'maquillaje')>Maquillaje</option>
    </select>
    @error('tipo_servicio') <p class="text-red-600 text-sm">{{ $message }}</p> 
    @enderror
  </div>

  <div>
    <label class="block font-medium">Duración (min)</label>
    <input type="number" name="duracion_min" class="w-full border rounded p-2"
    value="{{ old('duracion_min', $servicio->duracion_min) }}" min="15" max="600" required> 
    @error('duracion_min') <p class="text-red-600 text-sm">{{ $message }}</p> 
    @enderror
  </div>

  <div>
    <label class="block font-medium">Precio (€)</label>
    <input type="number" name="precio" step="0.01" class="w-full border rounded p-2"
    value="{{ old('precio', $servicio->precio) }}" min="0" required> 
    @error('precio') <p class="text-red-600 text-sm">{{ $message }}</p> 
    @enderror
  </div>

  <div class="flex items-center gap-2">
    <input type="checkbox" name="activo" id="activo" @checked(old('activo', $servicio->activo))>
    <label fir="activo">Activo</label>
  </div>

</div>

