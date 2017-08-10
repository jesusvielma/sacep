{{ csrf_field() }}
<div class="form-group {{ $errors->has('cedula_empleado') ? 'has-error' : ''}}">
	<label for="cedula_empleado">Cédula</label>
	<div class="tooltip-demo">
		<input id="cedula_empleado" type="text" name="cedula_empleado" value="{{ old('cedula_empleado',isset($empleado->cedula_empleado) ? $empleado->cedula_empleado : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Escribe la cédula sin separadores">
		@if ($errors->has('cedula_empleado'))
			<span class="help-block m-b-none">{{ $errors->first('cedula_empleado') }}</span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('nombre_completo') ? 'has-error' : ''}}">
	<label for="nombre_completo">Nombre completo del empleado</label>
		<input id="nombre_completo" type="text" name="nombre_completo" value="{{ old('nombre_completo',isset($empleado->nombre_completo) ? $empleado->nombre_completo : NULL) }}" class="form-control">
		@if ($errors->has('nombre_completo'))
			<span class="help-block m-b-none">{{ $errors->first('nombre_completo') }}</span>
		@endif
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group {{ $errors->has('fecha_nacimiento') ? 'has-error' : ''}}" id="data_3">
			<label >Fecha de Nacimiento</label>
			<div class="input-group date">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input name="fecha_nacimiento" type="text" class="form-control" value="{{ old('fecha_nacimiento',isset($empleado->fecha_nacimiento) ? $empleado->fecha_nacimiento : NULL) }}">
				@if ($errors->has('fecha_nacimiento'))
					<span class="help-block m-b-none">{{ $errors->first('fecha_nacimiento') }}</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group {{ $errors->has('fecha_ingreso') ? 'has-error' : ''}}" id="data_3">
			<label >Fecha de Ingreso a la empresa</label>
			<div class="input-group date">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input name="fecha_ingreso" type="text" class="form-control" value="{{ old('fecha_ingreso',isset($empleado->fecha_ingreso) ? $empleado->fecha_ingreso : NULL) }}">
				@if ($errors->has('fecha_ingreso'))
					<span class="help-block m-b-none">{{ $errors->first('fecha_ingreso') }}</span>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="form-group {{ $errors->has('id_cargo') ? 'has-error' : ''}}">
	<label for="cargo">Cargo</label>
	<select class="cargo form-control" name="id_cargo">
		<option></option>
		@foreach ($cargos as $cargo)
			@if (isset($empleado->id_cargo) && $empleado->id_cargo == $cargo->id_cargo)
				<option value="{{ $cargo->id_cargo }}" selected> {{ $cargo->nombre }}</option>
			@else
				<option value="{{ $cargo->id_cargo }}"> {{ $cargo->nombre }}</option>
			@endif
		@endforeach
	</select>
</div>

<div class="form-group {{ $errors->has('id_departamento') ? 'has-error' : ''}}">
	<label for="dep">Departamento</label>
	<select class="dep form-control" name="id_departamento">
		<option></option>
		@foreach ($deps as $dep)
			@if (isset($empleado->id_departamento) && $empleado->id_departamento == $dep->id_departamento)
				<option value="{{ $dep->id_departamento }}" selected> {{ $dep->nombre }}</option>
			@else
				<option value="{{ $dep->id_departamento }}"> {{ $dep->nombre }}</option>
			@endif
		@endforeach
	</select>
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
