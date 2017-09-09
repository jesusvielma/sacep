@extends('layouts.main')
@section('title')
	Trabajadores - Actas y Llamados de atención
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
			<h2>Trabajadores - Actas y Llamados de atención</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Trabajadores  - Actas y Llamados de atención</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			{{-- <div class="title-action">
				<a href="{{ route('articulo_nuevo') }}" class="ladda-button ladda-button-demo btn btn-primary" name="button" data-style="zoom-in"> Nuevo articulo</a>
			</div> --}}
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if ($empleados->count() || $cant_hijos>0)
				<div class="{{ Auth::user()->nivel == 'gerente' ? 'col-lg-10 col-lg-offset-1' : 'col-lg-8 col-lg-offset-2' }}">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Trabajadores</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>Cédula</th>
											<th>Trabajador</th>
											@if (Auth::user()->nivel == 'gerente')
												<th>Coordinación / Unidad</th>
											@endif
											<th style="width:25%">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empleados as $empleado)
											<tr>
												<td>{{ $empleado->cedula_empleado }}</td>
												<td>{{ $empleado->nombre_completo }}</td>
												@if (Auth::user()->nivel == 'gerente')
													<td>{{ $empleado->departamento->nombre }}</td>
												@endif
												<td class="tooltip-demo ">
													<div class="btn-group">
														<a href="{{ route('acta_nueva',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Levantar acta a {{ $empleado->nombre_completo }}"><i class="fa fa-file-text"></i></a>
														<a href="{{ route('ver_actas',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $empleado->nombre_completo }}"><i class="fa fa-files-o"></i></a>
													</div>
													<div class="btn-group">
														<a href="{{ route('llamado_nuevo',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Levantar llamado de atención a {{ $empleado->nombre_completo }}"><i class="fa fa-bullhorn"></i></a>
														<a href="{{ route('ver_llamados',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $empleado->nombre_completo }}"><i class="fa fa-files-o"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
										@if ($cant_hijos>0 && isset($hijos))
											{{ dd($hijos) }}
											@foreach ($hijos as $key => $hijo)
												<tr>
													<td>{{ $hijo->cedula_empleado }}</td>
													<td>{{ $hijo->nombre_completo }}</td>
													<td class="tooltip-demo">
														<div class="btn-group">
															<a href="{{ route('acta_nueva',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Levantar acta a {{ $hijo->nombre_completo }}"><i class="fa fa-file-text"></i></a>
															<a href="{{ route('ver_actas',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $hijo->nombre_completo }}"><i class="fa fa-files-o"></i></a>
														</div>
														<div class="btn-group">
															<a href="{{ route('llamado_nuevo',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Levantar llamado de atención a {{ $hijo->nombre_completo }}"><i class="fa fa-bullhorn"></i></a>
															<a href="{{ route('ver_llamados',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $hijo->nombre_completo }}"><i class="fa fa-files-o"></i></a>
														</div>
													</td>
												</tr>
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
						<p>Parece que no hay trabajadores en su {{ ucfirst(trans('enums.departamento.'.Auth::user()->empleado->departamento->tipo)) }}.</p>
						<p>Le recomendamos que verifique con la cooridinación encargada.</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
