{{ csrf_field() }}
<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
	<label for="nombre">Nombre del material</label>
	<input id="nombre" type="text" name="nombre" value="{{ old('nombre',isset($material->nombre) ? $material->nombre : NULL) }}" class="form-control">
	@if ($errors->has('nombre'))
		<span class="help-block m-b-none">{{ $errors->first('nombre') }}</span>
	@endif
</div>
<div class="form-group {{ $errors->has('codigo_material') ? 'has-error' : ''}}">
	<label for="codigo_material">Código del Material</label>
	<div class="tooltip-demo">
		<input id="codigo_material" type="text" name="codigo_material" value="{{ old('codigo_material',isset($material->codigo_material) ? $material->codigo_material : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Rellene esta campo solo si el material tiene un código especial">
		@if ($errors->has('codigo_material'))
			<span class="help-block m-b-none">{{ $errors->first('codigo_material') }}</span>
		@endif
	</div>
</div>
<div class="form-group">
	<label for="cantidad">Cantidad</label>
	<input class="touchspin2" type="text" value="{{old('porcentaje',isset($material->cantidad) ? $material->cantidad : NULL)}}" name="cantidad">
</div>
<input type="hidden" name="id_departamento" value="{{ isset($departamento->id_departamento) ? $departamento->id_departamento : $material->id_departamento }}">
{{-- <div class="form-group {{ $errors->has('id_cargo') ? 'has-error' : ''}}">
	<label for="cargo">Cargo</label>
	<select class="cargo form-control" name="id_cargo">
		<option></option>
		@foreach ($cargos as $cargo)
			@if (isset($material->id_cargo) && $material->id_cargo == $cargo->id_cargo)
				<option value="{{ $cargo->id_cargo }}" selected> {{ $cargo->nombre }}</option>
			@else
				<option value="{{ $cargo->id_cargo }}"> {{ $cargo->nombre }}</option>
			@endif
		@endforeach
	</select>
</div> --}}

{{-- <div class="form-group {{ $errors->has('id_departamento') ? 'has-error' : ''}}">
	<label for="dep">Departamento</label>
	<select class="dep form-control" name="id_departamento">
		<option></option>
		@foreach ($deps as $dep)
			@if (isset($material->id_departamento) && $material->id_departamento == $dep->id_departamento)
				<option value="{{ $dep->id_departamento }}" selected> {{ $dep->nombre }}</option>
			@else
				<option value="{{ $dep->id_departamento }}"> {{ $dep->nombre }}</option>
			@endif
		@endforeach
	</select>
</div> --}}
<div class="form-group">
	<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
</div>
