@extends('layouts.main')
@section('title')
	Listado de trabajadores a evaluar
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
	@if (session('notif'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<script>
		$(document).ready(function () {
			var l = $('.ladda-button-demo').ladda();

	        l.click(function(event){
	            l.ladda('start');
	        });

			$('#form_submit').click(function (event) {
				event.preventDefault();
				$('#form').submit();
			});

			$('.dataTables-example').DataTable({
                pageLength: 10,
                responsive: true,
				language: {
					url : '{{ URL::asset('js/plugins/dataTables/i18n/es.json') }}',
				},
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
				@if (isset($empl_consulta))
					order: [ [5,'desc'] ]
				@else
					order: [ [4,'desc'], [0,'asc'] ]
				@endif
            });
		});
	</script>
	@if (session('notif'))
		<!-- Toastr script -->
	    <script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>
		<script>
			toastr.options = {
			  "progressBar": false,
			  "positionClass": "toast-top-center",
			  "timeOut": "10000",
			}
			toastr.options.onclick = function () {
				window.open("{{ asset('storage/evaluaciones').'/'.session('notif.url') }}",'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
			};
			toastr.options.onHidden = function () {
				window.open("{{ asset('storage/evaluaciones').'/'.session('notif.url') }}",'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
			};
			// setTimeout(function () {
			// 	window.open("{{ asset('storage/evaluaciones').'/'.session('notif.url') }}",'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
			// },11000);
			toastr.{{ session('notif.type')}}('{{ session('notif.msg') }}','{{ session('notif.title') }}')
		</script>
	@endif
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Evaluar</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Trabajadores a evaluar</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if ($empleados->count() || $cant_hijos>0)
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Todos los trabjadores</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th style="width:15%">Cedula de identidad</th>
											<th>Nombre</th>
											<th style="width:15%">Fechad ingreso</th>
											<th>Cargo</th>
											<th>Adscrito a</th>
											<th style="width:10%">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empleados as $empleado)
											<tr>
												<td>{{ $empleado->cedula_empleado }}</td>
												<td>{{ $empleado->nombre_completo }}</td>
												<td>{{ $empleado->fecha_ingreso->format('d-m-Y') }}</td>
												<td>{{ $empleado->cargo ? $empleado->cargo->nombre : 'Debe darle un cargo a esta empleado' }}</td>
												<td>{{ $empleado->departamento->nombre }}</td>
												<td class="tooltip-demo">
													<a href="{{ route('evaluar',['id'=>$empleado->cedula_empleado])}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Evaluar a {{ $empleado->nombre_completo }}"><i class="fa fa-pie-chart"></i></a>
													<a href="{{ route('evaluaciones',['id'=>$empleado->cedula_empleado])}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Evaluaciones de {{ $empleado->nombre_completo }}"><i class="fa fa-list"></i></a>
												</td>
											</tr>
										@endforeach
										@if ($cant_hijos>0 && isset($hijos))
											@php
												$sons = [];
											@endphp
											@foreach ($hijos as $key => $hijo)
												<tr>
													<td>{{ $hijo->cedula_empleado }}</td>
													<td>{{ $hijo->nombre_completo }}</td>
													<td>{{ $hijo->fecha_ingreso->format('d-m-Y') }}</td>
													<td>{{ $hijo->cargo ? $hijo->cargo->nombre : 'Debe darle un cargo a esta empleado' }}</td>
													<td>{{ $hijo->departamento->nombre }}</td>
													<td class="tooltip-demo">
														<a href="{{ route('evaluar',['id'=>$hijo->cedula_empleado])}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Evaluar a {{ $hijo->nombre_completo }}"><i class="fa fa-pie-chart"></i></a>
														<a href="{{ route('evaluaciones',['id'=>$hijo->cedula_empleado])}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Evaluaciones de {{ $hijo->nombre_completo }}"><i class="fa fa-list"></i></a>
													</td>
												</tr>
												@php
													$sons = $sons + [$key => $hijo->cedula_empleado];
												@endphp

											@endforeach
										@endif

										@if ($cant_hijos>0 && isset($otros_empls))
											@foreach ($otros_empls as $otro_empl)
												@foreach ($otro_empl as $emp)
													<tr>
														<td>{{ $emp->cedula_empleado }}</td>
														<td>{{ $emp->nombre_completo }}</td>
														<td>{{ $emp->fecha_ingreso->format('d-m-Y') }}</td>
														<td>{{ $emp->cargo ? $emp->cargo->nombre : 'Debe darle un cargo a esta empleado' }}</td>
														<td>{{ $emp->departamento->nombre }}</td>
														<td class="tooltip-demo">
															<a href="{{ route('evaluar',['id'=>$emp->cedula_empleado])}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Evaluar a {{ $emp->nombre_completo }}"><i class="fa fa-pie-chart"></i></a>
															<a href="{{ route('evaluaciones',['id'=>$emp->cedula_empleado])}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Evaluaciones de {{ $emp->nombre_completo }}"><i class="fa fa-list"></i></a>
														</td>
													</tr>
												@endforeach
											@endforeach
										@endif
										@if ($cant_hijos>0 && isset($empl_consulta))
											@foreach ($empl_consulta as $consulta)
												@foreach ($consulta as $empl1)
													@if (!in_array($empl1->cedula_empleado,$sons))
														<tr>
															<td>{{ $empl1->cedula_empleado }}</td>
															<td>{{ $empl1->nombre_completo }}</td>
															<td>{{ $empl1->fecha_ingreso->format('d-m-Y') }}</td>
															<td>{{ $empl1->cargo ? $empl1->cargo->nombre : 'Debe darle un cargo a esta empleado' }}</td>
															<td>{{ $empl1->departamento->nombre }}</td>
															<td class="tooltip-demo">
																<a href="{{ route('evaluaciones',['id'=>$empl1->cedula_empleado])}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Evaluaciones de {{ $empl1->nombre_completo }}"><i class="fa fa-list"></i></a>
															</td>
														</tr>
													@endif
												@endforeach
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no hay empleados registrado para su coordinación.</p>
						<p>Le recomendamos verificar esta información con el coordinador encargado.</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
