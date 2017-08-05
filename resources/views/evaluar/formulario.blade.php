{{ csrf_field() }}
<h1>Datos Generales</h1>
<div>
	<h2>Datos generales</h2>
	<div class="row">
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-5">
					<h4>Nombre del trabajador</h4>
					<p>{{ $empleado->nombre_completo }}</p>
				</div>
				<div class="col-lg-4">
					<h4>Cédula de identidad</h4>
					<p>{{ $empleado->cedula_empleado }}</p>
					<input type="hidden" name="cedula_empleado" value="{{ $empleado->cedula_empleado }}">
				</div>
				<div class="col-lg-3">
					<h4>Cargo / Ocupación actual </h4>
					<p>{{ $empleado->cargo->nombre }}</p>
					<input type="hidden" name="cargo_trabajador_evaluado" value="{{ $empleado->cargo->id_cargo }}">
					<input type="hidden" name="departamento_trabajador_evaluado" value="{{ $empleado->departamento->id_departamento }}">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Motivo de evaluacion</label>
						<select class="form-control required" name="motivo">
							<option value="">- Seleccione -</option>
							<option value="regular">Regular</option>
							<option value="periodica">Periodica</option>
							<option value="renovacion">Renovación</option>
							<option value="ascenso">Ascenso</option>
							<option value="traslado">Traslado</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Tipo de evaluacion</label>
						<select class="form-control required" name="tipo" id="tipo">
							<option value="">- Seleccione -</option>
							<option value="mensual">Mensual</option>
							<option value="bimestral">Bimestral</option>
							<option value="trimestral">Trimestral</option>
							<option value="semestral">Semetral</option>
							<option value="anual">Anual</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<label>Fecha de emisión</label>
						<input id="fe" name="fecha_evaluacion" type="text" class="form-control required" readonly>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="form-group" id="data_5">
						<label>Periodo de evaluación</label>
						<div class="input-daterange input-group" id="datepicker">
							<span class="input-group-addon">Desde</span>
							<input type="text" class="form-control required" name="periodo_desde" >
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control required" name="periodo_hasta" />
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
					<div class="form-group">
						<label>Descripción, Motivo, Situación</label>
						<textarea name="descripcion" rows="5" class="form-control 255 required" maxlength="255"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Recomendación para asignación</label>
						<textarea name="recomendacion" rows="1" class="form-control 100 required" maxlength="80"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Comentario General del evaluador</label>
						<textarea name="comentario" rows="5" class="form-control 255 required" maxlength="255"></textarea>
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
