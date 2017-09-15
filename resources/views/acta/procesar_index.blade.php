@extends('layouts.main')
@section('title')
	Actas y llamados de atención por procesar
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
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
				columns :[
					null,
					null,
					null,
					null,
					null,
					{"orderable":false},
					{"orderable":false}
				]
            });
			$('.i-checks').iCheck({
			    checkboxClass: 'icheckbox_square-green',
			});
			$('#marcarTodos').click(function () {
				if ($(this).hasClass('btn-outline')) {
					$(this).removeClass('btn-outline');
					$('input:checkbox').attr('checked',true);
					$('.i-checks').iCheck({
					    checkboxClass: 'icheckbox_square-green',
					});
				}
				else{
					$(this).addClass('btn-outline');
					$('input:checkbox').attr('checked',false);
					$('.i-checks').iCheck({
					    checkboxClass: 'icheckbox_square-green',
					});
				}
			});
			$('.ver').click(function (event) {
				url = '{!! url('/') !!}/';
				event.preventDefault();
				tipo = $(this).data('tipo');
				id = $(this).data('id');
				if (tipo !='llamado') {
					url = url+'imprimir_acta/'+id;
				}
				else{
					url = url+'imprimir_llamado/'+id;
				}
				window.open(url,'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
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
			<h2>Actas y llamados de atención por procesar</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('actas') }}"> Trabajadores - Actas y Llamados de atención</a></li>
				<li class="active">
					<strong>Actas y llamados de atención por procesar</strong>
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
							<h5>Actas y llamados de atención por procesar</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							@if ($actas->count())
								<form class="" action="{{ route('procesar_varias_actas') }}" method="post">
									{{ csrf_field() }}
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover dataTables-example">
											<thead>
												<tr>
													<th>Fecha de emisión</th>
													<th>Tipo </th>
													<th>Sancionado</th>
													<th>Sancionador</th>
													<th>Coordinación/Unidad</th>
													<th style="width:10%">Acciones</th>
													<th class="tooltip-demo">
														<button type="button" class="btn btn-sm btn-success btn-outline dim" data-toggle="tooltip" data-placement="top" title="Marcar todos para procesar" id="marcarTodos"><i class="fa fa-check-square-o"></i></button>
													</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($actas as $acta)
													<tr>
														<td>{{ $acta->fecha->format('d-m-Y h:i:s a') }}</td>
														<td>
															{{ ucfirst(trans('enums.acta.'.$acta->tipo))}}
														</td>
														<td>
															@foreach ($acta->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'sancionado')
																	{{ $empleado->nombre_completo }}
																@endif
															@endforeach
														</td>
														<td>
															@foreach ($acta->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'sancionador')
																	{{ $empleado->nombre_completo }}
																@endif
															@endforeach
														</td>
														<td>
															@foreach ($acta->empleados as $empleado)
																@if ($empleado->pivot->tipo == 'sancionador')
																	{{ $empleado->departamento->nombre }}
																@endif
															@endforeach
														</td>
														<td class="tooltip-demo form-inline">
															<a class="btn btn-xs btn-primary ver" data-tipo="{{ $acta->tipo }}" data-id="{{ $acta->id_acta }}" href="#" data-toggle="tooltip" data-placement="top" title="Ver @lang('enums.acta.'.$acta->tipo) (abre en una nueva ventana)"><i class="fa fa-eye"></i></a>
															<a href="{{ route('procesar_acta',['id'=>$acta->id_acta]) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Procesar @lang('enums.acta.'.$acta->tipo)"><i class="fa fa-check"></i></a>
														</td>
														<td><div class="checkbox-inline i-checks">
															<label > <input type="checkbox" name="id_evaluacion[]" value="{{ $acta->id_acta }}"> </label>
														</div></td>
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
