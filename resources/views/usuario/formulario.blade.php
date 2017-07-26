{{ csrf_field() }}
<div class="form-group {{ $errors->has('trabajador') ? 'has-error' : ''}}">
	<label for="trabajador">Trabajador</label>
	<select class="trabajador form-control" name="cedula_empleado" id="trabajador" required>
		<option></option>
		@foreach ($empleados as $empleado)
			@if (isset($usuario->responsable) && $usuario->id_usuarios == $empleado->cedula_empleado)
				<option value="{{ $empleado->cedula_empleado }}" selected> {{ $empleado->nombre_completo }}</option>
			@else
				<option value="{{ $empleado->cedula_empleado }}"> {{ $empleado->nombre_completo }}</option>
			@endif
		@endforeach
	</select>
</div>
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
	<label for="nombre">Nombre para esta usuario</label>
	<div class="row">
		<div class="tooltip-demo col-lg-11">
			<input type="text" name="nombre" value="{{ old('nombre',isset($usuario->nombre) ? $usuario->nombre : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Se recomiendo utilizar un nommbre compuesto por Primero Nombre y Primer Apellido" {{ isset($usuario->nombre) ? '': 'readonly' }}>
		</div>
		<div class="col-lg-1">
			<button type="button" name="button" class="btn btn-default" id="editar_nombre"><i class="fa fa-edit"></i></button>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="correo">Correo electrónico</label>
	<input type="email" name="correo" class="form-control" required value="{{ old('correo',isset($usuario->correo) ? $usuario->correo : NULL ) }}">
</div>
<div class="form-group">
	<label for="clave">Clave</label>
	<input type="password" name="clave" class="form-control" value="{{ old('clave') }}" required>
</div>
<div class="form-group">
	<label for="estado">Permisos de </label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="gerente" name="nivel" id="inactivo" required> <i></i> Gerente </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="th" name="nivel" id="inactivo" required> <i></i> Talento Humano </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="coordinador" name="nivel" id="activo" required> <i></i> Coordinador </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="supervirsor" name="nivel" id="inactivo" required> <i></i> Supervisor </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="jefe" name="nivel" id="inactivo" required> <i></i> Jefe </label>
	</div>
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
