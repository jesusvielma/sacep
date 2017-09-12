{{ csrf_field() }}
<h1>Datos Generales</h1>
<div>
	<h2>Datos generales</h2>
	<div class="row">
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-5">
					<h4>Nombre del trabajador</h4>
					<p>{{ ($empleado->nombre_completo) }}</p>
				</div>
				<div class="col-lg-3">
					<h4>Cédula de identidad</h4>
					<p>{{ $empleado->cedula_empleado }}</p>
					<input type="hidden" name="cedula_empleado" value="{{ $empleado->cedula_empleado }}">
				</div>
				<div class="col-lg-4">
					<h4>Cargo / Ocupación actual </h4>
					<p>{{ $empleado->cargo->nombre }}</p>
					<input type="hidden" name="cargo_trabajador_evaluado" value="{{ $empleado->cargo->id_cargo }}">
					<input type="hidden" name="departamento_trabajador_evaluado" value="{{ $empleado->departamento->id_departamento }}">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Motivo de evaluación</label>
						<select class="form-control required" name="motivo">
							<option value="">- Seleccione -</option>
							<option value="regular" {{ isset($evaluacion->motivo) && $evaluacion->motivo == 'regular' ? 'selected' : NULL}}>Regular</option>
							<option value="periodica" {{ isset($evaluacion->motivo) && $evaluacion->motivo == 'periodica' ? 'selected' : NULL}}>Periódica</option>
							<option value="renovacion" {{ isset($evaluacion->motivo) && $evaluacion->motivo == 'renovacion' ? 'selected' : NULL}}>Renovación</option>
							<option value="ascenso" {{ isset($evaluacion->motivo) && $evaluacion->motivo == 'ascenso' ? 'selected' : NULL}}>Ascenso</option>
							<option value="traslado" {{ isset($evaluacion->motivo) && $evaluacion->motivo == 'traslado' ? 'selected' : NULL}}>Traslado</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Tipo de evaluación</label>
						<select class="form-control required" name="tipo" id="tipo">
							<option value="">- Seleccione -</option>
							<option value="mensual" {{ isset($evaluacion->tipo) && $evaluacion->tipo == 'mensual' ? 'selected' : NULL}}>Mensual</option>
							<option value="bimestral" {{ isset($evaluacion->tipo) && $evaluacion->tipo == 'bimestral' ? 'selected' : NULL}}>Bimestral</option>
							<option value="trimestral" {{ isset($evaluacion->tipo) && $evaluacion->tipo == 'trimestral' ? 'selected' : NULL}}>Trimestral</option>
							<option value="semestral" {{ isset($evaluacion->tipo) && $evaluacion->tipo == 'semetral' ? 'selected' : NULL}}>Semestral</option>
							<option value="anual" {{ isset($evaluacion->tipo) && $evaluacion->tipo == 'anual' ? 'selected' : NULL}}>Anual</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<label>Fecha de emisión</label>
						<input id="fe" name="fecha_evaluacion" type="text" class="form-control required" readonly value="{{ isset($evaluacion->fecha_evaluacion) ? $evaluacion->fecha_evaluacion : NULL}}">
					</div>
				</div>
				<div class="col-lg-8">
					<div class="form-group" id="data_5">
						<label>Periodo de evaluación</label>
						<div class="input-daterange input-group" id="datepicker">
							<span class="input-group-addon">Desde</span>
							<input type="text" class="form-control required" name="periodo_desde" value="{{ isset($evaluacion->periodo_desde) ? $evaluacion->periodo_desde->format('Y-m-d') : NULL}}" {{ isset($evaluacion->periodo_desde) ? 'readonly' : NULL}}>
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control required" name="periodo_hasta" value="{{ isset($evaluacion->periodo_hasta) ? $evaluacion->periodo_hasta->format('Y-m-d') : NULL}}" {{ isset($evaluacion->periodo_hasta) ? 'readonly' : NULL}}>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="text-center">
				<div style="margin-top: 20px">
					<i class="fa fa-user" style="font-size: 180px;color: #e5e5e5 "></i>
				</div>
			</div>
		</div>
	</div>

</div>
@foreach ($factores as $factor)
	<h1>{{ $factor->nombre }}</h1>
	<div>
		<h2>{{ $factor->nombre }} </h2>
		<div class="row">
			<div class="col-lg-10">
				<div class="row">
					@if (isset($evaluacion))
						@foreach ($evaluacion->item_evaluado as $item)
							@if ($factor->id_factor == $item->factor->id_factor)
								<div class="col-lg-6">
									<div class="form-group">
										<label>{{ $item->nombre }}</label>
										<div class="row">
											<div class="col-sm-10">
												<input name="items[{{ $item->id_item }}][puntaje]" type="text" class="form-control required range" value="{{ $item->pivot->puntaje }}" data-id="{{ $item->id_item }}">
												<input type="hidden" name="items[{{ $item->id_item }}][item_evaluado]" value="{{ $item->id_item }}">
												<!-- informacion del Item -->
												<div class="collapse" id="item-{{ $item->id_item }}">
													<div class="panel panel-info">
														<div class="panel-heading">
															<h4>{{ $item->nombre }}</h4>
														</div>
														<div class="panel-body">
															<p>{!! $item->informacion !!}</p>
														</div>
													</div>
												</div>
											</div>
											<!-- Fin informacion del item -->
											<div class="col-sm-2">
												<button class="btn btn-info dim" type="button" data-toggle="collapse" data-target="#item-{{ $item->id_item }}" aria-expanded="false" aria-controls="item-{{$item->id_item}}">
													<i class="fa fa-info"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					@else
						@foreach ($factor->items as $item)
							<div class="col-lg-6">
								<div class="form-group">
									<label>{{ $item->nombre }}</label>
									<div class="row">
										<div class="col-sm-10">
											<input name="items[{{ $item->id_item }}][puntaje]" type="text" class="form-control required range">
											<input type="hidden" name="items[{{ $item->id_item }}][item_evaluado]" value="{{ $item->id_item }}">
											<!-- informacion del Item -->
											<div class="collapse" id="item-{{ $item->id_item }}">
												<div class="panel panel-info">
													<div class="panel-heading">
														<h4>{{ $item->nombre }}</h4>
													</div>
													<div class="panel-body">
														<p>{!! $item->informacion !!}</p>
													</div>
												</div>
											</div>
										</div>
										<!-- Fin informacion del item -->
										<div class="col-sm-2">
											<button class="btn btn-info dim" type="button" data-toggle="collapse" data-target="#item-{{ $item->id_item }}" aria-expanded="false" aria-controls="item-{{$item->id_item}}">
												<i class="fa fa-info"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
			<div class="col-lg-2">
				<div class="text-center">
					<div style="margin-top: 20px; margin-left:-30px">
						<i class="fa fa-pie-chart" style="font-size: 180px;color: #e5e5e5 "></i>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach

<h1>Notas finales </h1>
<div>
	<h2>Notas finales</h2>
	<div class="row">
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group tooltip-demo">
						<label>Descripción, Motivo, Situación</label>
						<textarea name="descripcion" rows="5" class="form-control 255" maxlength="255" placeholder="Describa y detalle las razones, motivos y situación de los llamados de atención o amonestaciones y actas levantadas al trabajador evaluado. ">{{ isset($evaluacion->descripcion) ? $evaluacion->descripcion : NULL}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Recomendación para asignación</label>
						<textarea name="recomendacion" rows="2" class="form-control 100" maxlength="80" placeholder="Describa si el trabajador muestras habilidades o destrezas en otras áreas en las cuales el trabajador pudiera ser tomado en cuenta">{{ isset($evaluacion->recomendacion) ? $evaluacion->recomendacion : NULL}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Comentario General del evaluador</label>
						<textarea name="comentario" rows="5" class="form-control 255 required" maxlength="255" placeholder="Realice un resumen general cualitativo del desempeño del trabajador">{{ isset($evaluacion->comentario) ? $evaluacion->comentario : NULL}}</textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="text-center">
				<div style="margin-top: 20px; margin-left:-30px">
					<i class="fa fa-comments-o" style="font-size: 180px;color: #e5e5e5 "></i>
				</div>
			</div>
		</div>
	</div>
</div>
