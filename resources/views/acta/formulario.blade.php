{{ csrf_field() }}
<div class="form-group">
	<label class="col-sm-2 control-label">Sancionado</label>
    <div class="col-sm-5">
      <p class="form-control-static">{{ $empleado->nombre_completo }}</p>
    </div>
	<label class="col-sm-2 control-label">Cédula sancionado</label>
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
	<label class="col-sm-2 control-label">Cédula sancionador</label>
    <div class="col-sm-3">
      <p class="form-control-static">{{ Auth::user()->empleado->cedula_empleado }}</p>
	  <input type="hidden" name="sancionador" value="{{ Auth::user()->empleado->cedula_empleado }}">
    </div>
</div>

<div class="form-group {{ $errors->has('descripcion') ? 'has-error' : ''}}">
	<div class="col-md-12">
		<label for="descripcion">Descripción de la sanción</label>
		<textarea maxlength="255" name="descripcion" rows="3" class="form-control" id="editor">{{ isset($acta->descripcion) ? $acta->descripcion : (old('descripcion')) }}</textarea>
		@if ($errors->has('descripcion'))
			<span class="help-block m-b-none"><strong>{{ $errors->first('descripcion') }}</strong></span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('palabra_clave') ? 'has-error' : ''}}">
	<div class="col-lg-12">
		<label for="palabra_clave">Palabra clave de la sanción</label>
		<input type="text" name="palabra_clave" class="form-control" value="{{ old('palabra_clave',isset($acta->palabra_clave) ? $acta->palabra_clave : NULL)}}">
		<span class="help-block m-b-none">Ejemplo: ausencia, falta, etc</span>
		@if ($errors->has('palabra_clave'))
			<span class="help-block m-b-none">{{ $errors->first('palabra_clave') }}</span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('lugar') ? 'has-error' : ''}}">
	<div class="col-lg-12">
		<label for="lugar">Lugar donde se levanta la sanción</label>
		<input type="text" name="lugar" class="form-control" value="{{ old('lugar',isset($acta->lugar) ? $acta->lugar : NULL)}}">
		@if ($errors->has('lugar'))
			<span class="help-block m-b-none">{{ $errors->first('lugar') }}</span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('articulo') ? 'has-error' : ''}}">
	<div class="col-lg-12">
		<label>Articulo</label>
		<select class="select2 form-control articulo" name="articulo" required>
			<option></option>
		</select>
		@if ($errors->has('articulo'))
			<span class="help-block m-b-none">
				<ul>
					@foreach ($errors->get('articulo') as $msg)
						<li>{{ $msg }}</li>
					@endforeach
				</ul>
			</span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('lp') ? 'has-error' : ''}}">
	<div class="col-lg-12">
		<label >Literales y párrafos del articulo seleccionado</label>
		<select class="form-control articulo1" {{ isset($acta) ? NULL : 'disabled'}} multiple name="lp[]" required>
			{{-- @foreach ($articulos as $articulo)
				<option value="{{ $articulo->id_articulo }}" title="{{ $articulo->tipo }}">
					@if (!isset($articulo->padre))
						{{ ucfirst($articulo->tipo)}} {{$articulo->identificador}} de <b> {{ $articulo->ley }} </b>
					@elseif (isset($articulo->padre) && !isset($articulo->art_padre->padre))
						{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del {{ ucfirst($articulo->art_padre->tipo).' '.$articulo->art_padre->identificador }} de {{ $articulo->ley }}
					@endif
					@if (isset($articulo->art_padre->padre))
						{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del {{ ucfirst($articulo->art_padre->tipo) }} {{ $articulo->art_padre->identificador }} del {{ ucfirst($articulo->art_padre->art_padre->tipo).' '.$articulo->art_padre->art_padre->identificador }} de {{ $articulo->ley }}
					@endif
				</option>
			@endforeach --}}
		</select>
		@if ($errors->has('lp'))
			<span class="help-block m-b-none">
				<ul>
					@foreach ($errors->get('lp') as $msg)
						<li>{{ $msg }}</li>
					@endforeach
				</ul>
			</span>
		@endif
	</div>
</div>
@if (!isset($acta))
	<div class="form-group {{ $errors->has('testigo') ? 'has-error' : ''}}">
		<div class="col-lg-12">
			<label >Testigos</label>
			<select class="form-control testigos" multiple name="testigo[]"  required>
				@foreach ($deps as $dep)
					<optgroup label="{{ $dep->nombre }}">
						@foreach ($dep->empleados as $testigo)
							<option value="{{ $testigo->cedula_empleado }}" > {{ $testigo->nombre_completo }}</option>
						@endforeach
					</optgroup>
				@endforeach
			</select>
			@if ($errors->has('testigo'))
				<span class="help-block m-b-none">
					<ul>
						@foreach ($errors->get('testigo') as $msg)
							<li>{{ $msg }}</li>
						@endforeach
					</ul>
				</span>
			@endif
		</div>
	</div>
@endif
<div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}}">
	<div class="col-lg-12">
		<label >Tipo de sanción</label>
		<br>
		<div class="radio-inline i-checks">
			<label > <input type="radio" value="amonestacion" name="tipo" {{ isset($acta->tipo) && $acta->tipo == 'amonestacion' ? 'checked' : NULL}} required> <i></i> Amonestación </label>
		</div>
		<div class="radio-inline i-checks">
			<label > <input type="radio" value="inasistencia" name="tipo" {{ isset($acta->tipo) && $acta->tipo == 'inasistencia' ? 'checked' : NULL}} required> <i></i> Inasistencia </label>
		</div>
		@if ($errors->has('tipo'))
			<span class="help-block m-b-none">{{ $errors->first('tipo') }}</span>
		@endif
	</div>
</div>
<div class="form-group">
	<div class="col-lg-12">
		<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
	</div>
</div>
