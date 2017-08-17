{{ csrf_field() }}
<div class="form-group {{ $errors->has('identificador') ? 'has-error' : ''}}">
	<label for="identificador">Identificador</label>
	<div class="tooltip-demo">
		<input id="identificador" type="text" name="identificador" value="{{ old('identificador',isset($articulo->identificador) ? $articulo->identificador : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Número de articulo, letra del literal o párrafo">
		@if ($errors->has('identificador'))
			<span class="help-block m-b-none">{{ $errors->first('identificador') }}</span>
		@endif
	</div>
</div>
<div class="form-group {{ $errors->has('nombre_completo') ? 'has-error' : ''}}">
	<label for="nombre_completo">Texto citado</label>
	<textarea name="contenido" rows="8" cols="80" class="form-control" id="editor">{{ isset($articulo->contenido) ? $articulo->contenido : NULL }}</textarea>
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none">{{ $errors->first('contenido') }}</span>
	@endif
</div>
<div class="form-group {{ $errors->has('ley') ? 'has-error' : ''}}">
	<label for="nombre_completo">Nombre dela ley a la que pertenece</label>
	<input type="text" name="ley" class="form-control" value="{{ $articulo->ley }}">
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none">{{ $errors->first('ley') }}</span>
	@endif
</div>
<div class="form-group {{ $errors->has('gravedad') ? 'has-error' : ''}}">
	<label for="nombre_completo">Gravedad que representa el articulo</label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="amonestacion" name="gravedad" {{ isset($articulo->gravedad) && $articulo->gravedad == 'amonestacion' ? 'checked' : NULL }} required> <i></i> Amonestación </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="falta" name="gravedad" {{ isset($articulo->gravedad) && $articulo->gravedad == 'falta'  ? 'checked' : NULL}} required> <i></i> Falta </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="inasistencia" name="gravedad" {{ isset($articulo->gravedad) && $articulo->gravedad == 'inasistencia'? 'checked' : NULL  }} required> <i></i> Inasistencia </label>
	</div>
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none">{{ $errors->first('gravedad') }}</span>
	@endif
</div>
<div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}}">
	<label for="nombre_completo">Este registro es un</label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="articulo" name="tipo" {{ isset($articulo->tipo) && $articulo->tipo == 'articulo' ? 'checked' : NULL}} required> <i></i> Articulo </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="literal" name="tipo" {{ isset($articulo->tipo) && $articulo->tipo == 'literal' ? 'checked' : NULL}} required> <i></i> Literal </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="parrafo" name="tipo" {{ isset($articulo->tipo) && $articulo->tipo == 'parrafo' ? 'checked' : NULL}} required> <i></i> Párrafo </label>
	</div>
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none">{{ $errors->first('tipo') }}</span>
	@endif
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
