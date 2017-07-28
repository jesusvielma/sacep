{{ csrf_field() }}
<h1>Datos Generales</h1>
<div>
	<h2>Datos generales</h2>
	<div class="row">
		<div class="col-lg-10">
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
							<input type="text" class="form-control required" name="periodo_desde"/>
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control required" name="periodo_hasta" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<h4>Nombre del trabajador</h4>
					<p>{{ $empleado->nombre_completo }}</p>
				</div>
				<div class="col-lg-4">
					<h4>Cédula de identidad</h4>
					<p>{{ $empleado->cedula_empleado }}</p>
				</div>
				<div class="col-lg-3">
					<h4>Cargo / Ocupación actual </h4>
					<p>{{ $empleado->cargo->nombre }}</p>
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
						<select class="form-control required" name="tipo">
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
										<input name="na" type="text" class="form-control required range">
										<div class="collapse" id="item-{{ $item->id_item }}">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4>{{ $item->nombre }}</h4>
												</div>
												<div class="panel-body">
													<p>{{ $item->informacion }}</p>
												</div>
											</div>
										</div>
									</div>
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

<h1>Finish</h1>
<div>
	<h2>Terms and Conditions</h2>
	<input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
</div>
