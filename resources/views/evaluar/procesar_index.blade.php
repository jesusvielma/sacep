@extends('layouts.main')
@section('title')
	Evaluaciones por procesar
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
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
	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
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
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
            });
			$('.i-checks').iCheck({
			    checkboxClass: 'icheckbox_square-green',
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
			}
			toastr.{{ session('notif.type')}}('{{ session('notif.msg') }}','{{ session('notif.title') }}')
		</script>
	@endif
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Evaluaciones por procesar</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('index_evaluar') }}"> Listado de trabajadores a evaluar </a></li>
				<li class="active">
					<strong>Procesar evaluaciones</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Todos las evaluaciones</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							@if ($evaluaciones->count())
								<form class="" action="{{ route('procesar_varias') }}" method="post">
									{{ csrf_field() }}
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover dataTables-example">
											<thead>
												<tr>
													<th>Fecha de emision</th>
													<th>Periodo de evaluación </th>
													<th style="width:10%">Puntaje Final</th>
													<th>Evaluado</th>
													<th>Evaluador</th>
													<th>Coordinación/Unidad</th>
													<th style="width:15%">Acciones</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($evaluaciones as $evaluacion)
													@php
													$puntaje = 0;
													$cant_items = $evaluacion->item_evaluado->count();
													@endphp
													<tr>
														<td>{{ $evaluacion->fecha_evaluacion->format('d-m-Y h:i:s a') }}</td>
														<td>
															{{ $evaluacion->periodo_desde->format('d-m-Y') }} | {{ $evaluacion->periodo_hasta->format('d-m-Y') }}
														</td>
														<td>
															@foreach ($evaluacion->item_evaluado as $item)
																@php
																$puntaje = $puntaje + $item->pivot->puntaje;
																@endphp
															@endforeach
															{{ round($puntaje = $puntaje/$cant_items,1) }}
														</td>
														<td>
															@foreach ($evaluacion->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'evaluado')
																	{{ $empleado->nombre_completo }}
																@endif
															@endforeach
														</td>
														<td>
															@foreach ($evaluacion->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'evaluador')
																	{{ $empleado->nombre_completo }}
																@endif
															@endforeach
														</td>
														<td>
															@foreach ($evaluacion->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'evaluador')
																	{{ $empleado->departamento->nombre }}
																@endif
															@endforeach
														</td>
														<td>
															<a class="btn btn-xs btn-primary" href="{{ route('imprimir_evaluacion',['id'=> $evaluacion->id_evaluacion]) }}"><i class="fa fa-eye"></i></a>
															<a href="{{ route('procesar_una',['id'=>$evaluacion->id_evaluacion]) }}" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a>
															<div class="checkbox-inline i-checks">
																<label > <input type="checkbox" name="id_evaluacion[]" value="{{ $evaluacion->id_evaluacion }}"> </label>
															</div>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-lg-4 col-lg-offset-8 text-right">
											<button type="submit" class="btn btn-success">Procesar Lote</button>
										</div>
									</div>
								</form>
							@else
								<div class="alert alert-info">
									<h4>Todo ha sido procesado por ahora</h4>
									<p>Le informamos que ya han sido procesadas todas las evaluaciones</p>
								</div>
							@endif
						</div>
					</div>
				</div>
		</div>
	</div>

@endsection
