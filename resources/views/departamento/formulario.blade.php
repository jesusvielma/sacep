{{ csrf_field() }}
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
	<label for="nombre">Nombre del departamento</label>
	<input type="text" name="nombre" value="{{ old('nombre',isset($dep->nombre) ? $dep->nombre : NULL) }}" class="form-control">
</div>
<div class="form-group {{ $errors->has('responsable') ? 'has-error' : ''}}">
	<label for="responsable">Responsable</label>
	<select class="responsable form-control" name="responsable">
		<option></option>
		@foreach ($empleados as $empleado)
			@if (isset($dep->responsable) && $dep->responsable == $empleado->cedula_empleado)
				<option value="{{ $empleado->cedula_empleado }}" selected> {{ $empleado->nombre_completo }}</option>
			@else
				<option value="{{ $empleado->cedula_empleado }}"> {{ $empleado->nombre_completo }}</option>
			@endif
		@endforeach
	</select>
</div>
<div class="form-group {{ $errors->has('responsable') ? 'has-error' : ''}}">
	<label for="estado">Tipo </label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="coordinacion" name="tipo" id="coord" {{ isset($dep->tipo) =='coordinacion' ? 'checked' : NULL }}> <i></i> Coordinación </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="unidad" name="tipo" id="unidad" {{ isset($dep->tipo) == 'unidad' ? 'checked' : NULL }}> <i></i> Unidad </label>
	</div>
</div>
<div class="form-group {{ $errors->has('responsable') ? 'has-error' : ''}}" id="selectUnidad">
	<label for="">Coordinación para la unidad que se creada</label>
	<select class="depto form-control" name="departamento_padre" {{ isset($dep->tipo) && $dep->tipo == 'unidad' ? NULL : 'disabled'}}>
		<option></option>
		@foreach ($deps as $dept)
			@if (isset($dep->tipo) && $dept->id_departamento == $dep->departamento_padre)
				<option value="{{ $dept->id_departamento }}" selected> {{ $dept->nombre }}</option>
			@else
				<option value="{{ $dept->id_departamento }}"> {{ $dept->nombre }}</option>
			@endif
		@endforeach
	</select>
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
