<div class="space-y-4">
  <div>
    <label class="block-font-medium">Día de la semana</label>

    @php $dia = old('dia_semana', $horario->dia_semana); @endphp

    <select name="dia_semana" class="w-full border rounded p-2" required>
      <option value="1" @selected($dia==1)>Lunes</option>
      <option value="2" @selected($dia==2)>Martes</option>
      <option value="3" @selected($dia==3)>Miércoles</option>
      <option value="4" @selected($dia==4)>Jueves</option>
      <option value="5" @selected($dia==5)>Viernes</option>
      <option value="6" @selected($dia==6)>Sábado</option>
      <option value="0" @selected($dia==0)>Domingo</option>
    </select>
  </div>

  <div>
    <label class="block font-medium">Hora inicio</label>
    <input type="time"
           name="hora_inicio"
           class="w-full border rounded p-2"
           value="{{ old('hora_inicio', $horario->hora_inicio) }}"
           required>
  </div>

  <div>
    <label class="block font-medium">Hora fin</label>
    <input type="time"
           name="hora_fin"
           class="w-full border rounded p-2"
           value="{{ old('hora_fin', $horario->hora_fin) }}"
           required>
  </div>

  <div class="flex items-center gap-2">
    <input type="checkbox"
           name="activo"
           id="activo"
           @checked(old('activo', $horario->activo))>
    <label for="activo">Activo</label>
  </div>
</div>