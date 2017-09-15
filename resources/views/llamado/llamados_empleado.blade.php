@extends('layouts.main')
@section('title')
	Listado de llamados de atención del trabajador {{$empleado->nombre_completo}}
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
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
            });
			$('.ver').click(function (event) {
				event.preventDefault();
				url = $(this).attr('href');
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
			<h2>Llamados de atención de {{ $empleado->nombre_completo }}</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('index_evaluar') }}"> Actas y Llamados de atención / Listado de trabajadores </a></li>
				<li class="active">
					<strong>{{ $empleado->nombre_completo }}</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<a href="{{ route('llamado_nuevo',['empleado'=>$empleado->cedula_empleado]) }}" class="ladda-button ladda-button-demo btn btn-primary" name="button" data-style="zoom-in"> Registrar acta</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Todos los llamados de atención</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th style="width:15%">Fecha</th>
											<th>Situación</th>
											<th>Estado</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empleado->actas as $acta)
											@if ($empleado->actas->count())
												@if ($acta->tipo=='llamado')
													<tr>
														<td>{{ $acta->fecha->formatLocalized('%d de %B de %Y') }}</td>
														<td>{{ $acta->descripcion }}</td>
														<td>{{ ucfirst($acta->estado) }}</td>
														<td class="tooltip-demo">
															<a class="btn btn-xs btn-primary ver" href="{{ route('imprimir_llamado',['id'=> $acta->id_acta]) }}" data-toggle="tooltip" data-placement="top" title="Ver este llamado de atención"><i class="fa fa-eye"></i></a>
															@if ($acta->estado == 'guardada')
																<a class="btn btn-xs btn-success" href="{{ route('editar_llamado',['id'=>$acta->id_acta]) }}" data-toggle="tooltip" data-placement="top" title="Editar este llamado de atención"><i class="fa fa-pencil"></i></a>
															@endif
														</td>
													</tr>
												@endif
											@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>

@endsection
