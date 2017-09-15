{{ csrf_field() }}
<div class="form-group">
	<label class="col-sm-2 control-label">Sancionado</label>
    <div class="col-sm-5">
      <p class="form-control-static">{{ $empleado->nombre_completo }}</p>
    </div>
	<label class="col-sm-2 control-label">Cédula de identidad del sancionado</label>
    <div class="col-sm-3">
      <p class="form-control-static">{{ $empleado->cedula_empleado }}</p>
	  <input type="hidden" name="sancionado" value="{{ $empleado->cedula_empleado }}" readonly class="form-control">
    </div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">Sancionador</label>
    <div class="col-sm-5">
      <p class="form-control-static">{{ Auth::user()->empleado->nombre_completo }}</p>
    </div>
	<label class="col-sm-2 control-label">Cédula de identidad del sancionador</label>
    <div class="col-sm-3">
      <p class="form-control-static">{{ Auth::user()->empleado->cedula_empleado }}</p>
	  <input type="hidden" name="sancionador" value="{{ Auth::user()->empleado->cedula_empleado }}">
    </div>
</div>

<div class="form-group {{ $errors->has('descripcion') ? 'has-error' : ''}}">
	<div class="col-md-12">
		<label for="descripcion">Descripción de la situación</label>
		<textarea maxlength="500" name="descripcion" rows="6" class="form-control" id="editor">{{ isset($llamado->descripcion) ? $llamado->descripcion : (old('descripcion')) }}</textarea>
		@if ($errors->has('descripcion'))
			<span class="help-block m-b-none"><strong>{{ $errors->first('descripcion') }}</strong></span>
		@endif
	</div>
</div>
<div class="form-group">
	<div class="col-lg-12">
		<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
	</div>
</div>
