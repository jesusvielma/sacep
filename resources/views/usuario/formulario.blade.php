{{ csrf_field() }}
<div class="form-group {{ $errors->has('trabajador') ? 'has-error' : ''}}">
	<label for="trabajador">Trabajador</label>
			@if (isset($usuario->id_usuario))
				<input value="{{ $usuario->empleado->nombre_completo }}" type="text" readonly class="form-control">
			@else
				<select class="trabajador form-control" name="cedula_empleado" id="trabajador" required>
					<option></option>
					@foreach ($empleados as $dep)
						@if ($dep->empleados()->count())
							<optgroup label="{{ $dep->nombre }}">
									@foreach ($dep->empleados as $empleado)
										<option value="{{ $empleado->cedula_empleado }}" {{ isset($empleado->id_usuario) && $empleado->usuario->estado == 1 ? 'disabled' : NULL }} title="Cargo: {{ $empleado->cargo->nombre }}"> {{ $empleado->nombre_completo }} </option>
									@endforeach
							</optgroup>
						@endif
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
	<label for="nombre">Nombre para mostrar en el sistema</label>
	<div class="row">
		<div class="tooltip-demo {{ isset($usuario->nombre) ? 'col-lg-12' : 'col-lg-11'}}">
			<input type="text" name="nombre" value="{{ old('nombre',isset($usuario->nombre) ? $usuario->nombre : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Se recomienda utilizar un nombre compuesto del primer Nombre y primer Apellido" {{ isset($usuario->nombre) ? '': 'readonly' }}>
		</div>
		@if (!isset($usuario->nombre))
			<div class="col-lg-1 tooltip-demo">
				<button type="button" name="button" class="btn btn-default dim" id="editar_nombre" data-toggle="tooltip" data-placement="top" title="Editar el nombre para mostrar"><i class="fa fa-edit"></i></button>
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
	<label for="estado">Permisos de </label> <button tabindex="0" type="button" class="btn btn-info dim" role="button" data-toggle="popover" data-trigger="focus" title="Información" data-content="Los usuarios para talento humano y gerencia tiene los permisos necesarios porque lsolo es necesario crear con el permiso correspondiente "><i class="fa fa-info"></i></button>
	<br>
	@if (!$gerente)
		<div class="radio-inline i-checks">
			<label > <input type="radio" value="gerente" name="nivel" id="inactivo" required {{ isset($usuario->nivel) && $usuario->nivel =='gerente' ? 'checked' : NULL }}> <i></i> Gerente </label>
		</div>
	@endif
	@if (!$th)
		<div class="radio-inline i-checks">
			<label > <input type="radio" value="th" name="nivel" id="inactivo" required {{ isset($usuario->nivel) && $usuario->nivel == 'th' ? 'checked' : NULL }}> <i></i> Talento Humano </label>
		</div>
	@endif
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="coordinador" name="nivel" id="activo" required {{ isset($usuario->nivel) && $usuario->nivel == 'coordinador' ? 'checked' : NULL }}> <i></i> Coordinador </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="supervisor" name="nivel" id="inactivo" required {{ isset($usuario->nivel) && $usuario->nivel == 'supervisor' ? 'checked' : NULL }}> <i></i> Supervisor </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="jefe" name="nivel" id="inactivo" required {{ isset($usuario->nivel) && $usuario->nivel== 'jefe' ? 'checked' : NULL }}> <i></i> Jefe </label>
	</div>

	@if ($errors->has('nivel'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('nivel') }}</strong>
		</span>
	@endif

	@isset($usuario->estado)
		<input type="hidden" name="estado" value="{{ $usuario->estado }}">
	@endisset
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
