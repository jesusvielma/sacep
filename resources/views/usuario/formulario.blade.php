{{ csrf_field() }}
<div class="form-group {{ $errors->has('trabajador') ? 'has-error' : ''}}">
	<label for="trabajador">Trabajador</label>
			@if (isset($usuario->id_usuario))
				<input value="{{ $usuario->empleado->nombre_completo }}" type="text" readonly class="form-control">
			@else
				<select class="trabajador form-control" name="cedula_empleado" id="trabajador" required>
					<option></option>
					@foreach ($empleados as $empleado)
						<option value="{{ $empleado->cedula_empleado }}"> {{ $empleado->nombre_completo }}</option>
					@endforeach
				</select>
			@endif
	@if ($errors->has('trabajador'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('trabajador') }}</strong>
		</span>
	@endif
</div>
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
	<label for="nombre">Nombre para esta usuario</label>
	<div class="row">
		<div class="tooltip-demo {{ isset($usuario->nombre) ? 'col-lg-12' : 'col-lg-11'}}">
			<input type="text" name="nombre" value="{{ old('nombre',isset($usuario->nombre) ? $usuario->nombre : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Se recomiendo utilizar un nommbre compuesto por Primero Nombre y Primer Apellido" {{ isset($usuario->nombre) ? '': 'readonly' }}>
		</div>
		@if (!isset($usuario->nombre))
			<div class="col-lg-1">
				<button type="button" name="button" class="btn btn-default" id="editar_nombre"><i class="fa fa-edit"></i></button>
			</div>
		@endif
		@if ($errors->has('nombre'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('nombre') }}</strong>
			</span>
		@endif
	</div>
</div>
<div class="form-group">
	<label for="correo">Correo electrónico</label>
	<input type="email" name="correo" class="form-control" required value="{{ old('correo',isset($usuario->correo) ? $usuario->correo : NULL ) }}">
	@if ($errors->has('correo'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('correo') }}</strong>
		</span>
	@endif
</div>
<div class="form-group">
	<label for="clave">Clave</label>
	<input type="password" name="clave" class="form-control" value="{{ old('clave') }}" {{ isset($usuario) ? NULL : 'required'}}>
	@if ($errors->has('clave'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('clave') }}</strong>
		</span>
	@endif
</div>
<div class="form-group">
	<label for="estado">Permisos de </label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="gerente" name="nivel" id="inactivo" required {{ isset($usuario->nivel) =='gerente' ? 'checked' : NULL }}> <i></i> Gerente </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="th" name="nivel" id="inactivo" required {{ isset($usuario->nivel) == 'th' ? 'checked' : NULL }}> <i></i> Talento Humano </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="coordinador" name="nivel" id="activo" required {{ isset($usuario->nivel) == 'coordinador' ? 'checked' : NULL }}> <i></i> Coordinador </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="supervisor" name="nivel" id="inactivo" required {{ isset($usuario->nivel) == 'supervisor' ? 'checked' : NULL }}> <i></i> Supervisor </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="jefe" name="nivel" id="inactivo" required {{ isset($usuario->nivel)== 'jefe' ? 'checked' : NULL }}> <i></i> Jefe </label>
	</div>
	@if ($errors->has('nivel'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('nivel') }}</strong>
		</span>
	@endif
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
