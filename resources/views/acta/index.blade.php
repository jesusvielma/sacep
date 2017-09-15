@extends('layouts.main')
@section('title')
	Trabajadores - Actas y llamados de atención
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
					order: [ [3,'desc'] ]
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
				window.open("{{ asset('storage').'/'.session('notif.url') }}",'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
			};
			setTimeout(function () {
				window.open("{{ asset('storage').'/'.session('notif.url') }}",'Vista de impresión','width=1024,height=768,titlebar=no,left=100');
			},11000);
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
				<div class="col-lg-10 col-lg-offset-1">
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
											<th>Cédula de identidad</th>
											<th>Trabajador</th>
											<th>Coordinación / Unidad</th>
											<th style="width:25%">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empleados as $empleado)
											<tr>
												<td>{{ $empleado->cedula_empleado }}</td>
												<td>{{ $empleado->nombre_completo }}</td>
												<td>{{ $empleado->departamento->nombre }}</td>
												<td class="tooltip-demo ">
													<div class="btn-group">
														<a href="{{ route('acta_nueva',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Registrar acta a {{ $empleado->nombre_completo }}"><i class="fa fa-file-text"></i></a>
														<a href="{{ route('ver_actas',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $empleado->nombre_completo }}"><i class="fa fa-files-o"></i></a>
													</div>
													<div class="btn-group">
														<a href="{{ route('llamado_nuevo',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Registrar llamado de atención a {{ $empleado->nombre_completo }}"><i class="fa fa-bullhorn"></i></a>
														<a href="{{ route('ver_llamados',['id'=>$empleado->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $empleado->nombre_completo }}"><i class="fa fa-files-o"></i></a>
													</div>
												</td>
											</tr>
										@endforeach
										@if ($cant_hijos>0 && isset($hijos))
											@foreach ($hijos as $hijo)
												<tr>
													<td>{{ $hijo->cedula_empleado }}</td>
													<td>{{ $hijo->nombre_completo }}</td>
													<td>{{ $hijo->departamento->nombre }}</td>
													<td class="tooltip-demo">
														<div class="btn-group">
															<a href="{{ route('acta_nueva',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Registrar acta a {{ $hijo->nombre_completo }}"><i class="fa fa-file-text"></i></a>
															<a href="{{ route('ver_actas',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $hijo->nombre_completo }}"><i class="fa fa-files-o"></i></a>
														</div>
														<div class="btn-group">
															<a href="{{ route('llamado_nuevo',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Registrar llamado de atención a {{ $hijo->nombre_completo }}"><i class="fa fa-bullhorn"></i></a>
															<a href="{{ route('ver_llamados',['id'=>$hijo->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $hijo->nombre_completo }}"><i class="fa fa-files-o"></i></a>
														</div>
													</td>
												</tr>
											@endforeach
										@endif
										@if ($cant_hijos>0 && isset($empl_consulta))
											@foreach ($empl_consulta as $consulta)
												@foreach ($consulta as $empl1)
													<tr>
														<td>{{ $empl1->cedula_empleado }}</td>
														<td>{{ $empl1->nombre_completo }}</td>
														<td>{{ $empl1->departamento->nombre }}</td>
														<td class="tooltip-demo">
															<div class="btn-group">
																<a href="{{ route('ver_actas',['id'=>$empl1->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $empl1->nombre_completo }}"><i class="fa fa-files-o"></i></a>
															</div>
															<div class="btn-group">
																<a href="{{ route('ver_llamados',['id'=>$empl1->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $empl1->nombre_completo }}"><i class="fa fa-files-o"></i></a>
															</div>
														</td>
													</tr>
												@endforeach
											@endforeach
										@endif
										@if ($cant_hijos>0 && isset($otros_empls))
											@foreach ($otros_empls as $otro_empl)
												@foreach ($otro_empl as $emp)
													<tr>
														<td>{{ $emp->cedula_empleado }}</td>
														<td>{{ $emp->nombre_completo }}</td>
														<td>{{ $emp->departamento->nombre }}</td>
														<td class="tooltip-demo">
															<div class="btn-group">
																<a href="{{ route('acta_nueva',['id'=>$emp->cedula_empleado])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Registrar acta a {{ $emp->nombre_completo }}"><i class="fa fa-file-text"></i></a>
																<a href="{{ route('ver_actas',['id'=>$emp->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver actas de {{ $emp->nombre_completo }}"><i class="fa fa-files-o"></i></a>
															</div>
															<div class="btn-group">
																<a href="{{ route('llamado_nuevo',['id'=>$emp->cedula_empleado])}}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Registrar llamado de atención a {{ $emp->nombre_completo }}"><i class="fa fa-bullhorn"></i></a>
																<a href="{{ route('ver_llamados',['id'=>$emp->cedula_empleado])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ver llamados de atención de {{ $emp->nombre_completo }}"><i class="fa fa-files-o"></i></a>
															</div>
														</td>
														</td>
													</tr>
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
						<p>Parece que no hay trabajadores en su {{ ucfirst(trans('enums.departamento.'.Auth::user()->empleado->departamento->tipo)) }}.</p>
						<p>Le recomendamos que verifique con la cooridinación encargada.</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
