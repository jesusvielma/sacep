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
<div class="form-group {{ $errors->has('contenido') ? 'has-error' : ''}}">
	<label for="nombre_completo">Texto citado</label>
	<textarea name="contenido" rows="8" cols="80" class="form-control" id="editor">{{ isset($articulo->contenido) ? $articulo->contenido : NULL }}</textarea>
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none"><strong>{{ $errors->first('contenido') }}</strong></span>
	@endif
</div>
<div class="form-group {{ $errors->has('ley') ? 'has-error' : ''}}">
	<label for="nombre_completo">Nombre de la ley a la que pertenece</label>
	<input type="text" name="ley" class="form-control" value="{{ old('ley',isset($articulo->ley) ? $articulo->ley : NULL)}}">
	@if ($errors->has('contenido'))
		<span class="help-block m-b-none">{{ $errors->first('ley') }}</span>
	@endif
</div>
<div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}}">
	<label for="nombre_completo">Este registro es un</label>
	<br>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="articulo" id="articulo" name="tipo" {{ old('tipo',(isset($articulo->tipo) && $articulo->tipo == 'articulo' ? 'checked' : NULL)) }} required> <i></i> Articulo </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="literal" id="literal" name="tipo" {{ old('tipo',(isset($articulo->tipo) && $articulo->tipo == 'literal' ? 'checked' : NULL)) }} required> <i></i> Literal </label>
	</div>
	<div class="radio-inline i-checks">
		<label > <input type="radio" value="parrafo" id="parrafo" name="tipo" {{ old('tipo',(isset($articulo->tipo) && $articulo->tipo == 'parrafo' ? 'checked' : NULL)) }} required> <i></i> Párrafo </label>
	</div>
	@if ($errors->has('ley'))
		<span class="help-block m-b-none">{{ $errors->first('tipo') }}</span>
	@endif
</div>
@if ($articulos->count())
	<div class="form-group">
		<label>Literal o párrafo contenido en:</label>
		<select class="padre form-control" name="padre" {{ isset($articulo->tipo) && ($articulo->tipo == 'literal' || $articulo->tipo == 'parrafo') ? NULL : 'disabled'}}>
			<option></option>
			@foreach ($articulos as $art)
				@if ($art->tipo == 'articulo' || $art->tipo == 'literal')
					<option value="{{ $art->id_articulo }}" class="{{ $art->tipo }}" disabled {{ isset($articulo->padre) && $art->id_articulo == $articulo->id_articulo ? 'checked' : NULL}}> {{ $art->ley }} {{ $art->identificador }}</option>
				@endif
			@endforeach
		</select>
	</div>
@endif
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
