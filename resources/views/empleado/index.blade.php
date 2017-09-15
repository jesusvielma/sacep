@extends('layouts.main')
@section('title')
	Listado de trabajadores
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
			<h2>Trabajadores</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Trabajadores</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<a href="{{ route('empleado_nuevo') }}" class="ladda-button ladda-button-demo btn btn-primary" name="button" data-style="zoom-in"> Nuevo trabajador</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if (count($empleados)>0)
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Todos los trabajadores</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>Cédula de identidad</th>
											<th>Nombre</th>
											<th>Fechad ingreso</th>
											<th>Fecha de nacimiento</th>
											<th>Estado</th>
											<th>Cargo</th>
											<th>Departamento</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empleados as $empleado)
											<tr>
												<td>{{ $empleado->cedula_empleado }}</td>
												<td>{{ $empleado->nombre_completo }}</td>
												<td>{{ $empleado->fecha_ingreso->format('d-m-Y') }}</td>
												<td>{{ $empleado->fecha_nacimiento->format('d-m-Y') }}</td>
												<td>{{ $empleado->estado }}</td>
												<td>{{ $empleado->cargo ? $empleado->cargo->nombre : 'Debe darle un cargo a esta empleado' }}</td>
												<td>{{ $empleado->departamento ? $empleado->departamento->nombre : 'Debe asociar al empleado a un departamento' }}</td>
												<td class="tooltip-demo">
													<a href="{{ route('editar_empleado',['id'=>$empleado->cedula_empleado])}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Editar información de {{ $empleado->nombre_completo }}"><i class="fa fa-pencil"></i></a>
												</td>
											</tr>
										@endforeach
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
						<p>Parece que no hay empleados en la base de datos.</p>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para ingresar un nuevo empleado</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
