{{ csrf_field() }}
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
	<label for="nombre">Nombre del factor</label>
	<input type="text" name="nombre" value="{{ old('nombre',isset($factor->nombre) ? $factor->nombre : NULL) }}" class="form-control">
</div>
<div class="form-group {{ $errors->has('responsable') ? 'has-error' : ''}}">
	<label for="responsable">Responsable</label>
	
</div>
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
