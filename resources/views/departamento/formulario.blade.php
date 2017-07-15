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
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
