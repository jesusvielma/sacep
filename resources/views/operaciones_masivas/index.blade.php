@extends('layouts.main')
@section('title')
	Listado de usuarios
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
	@if (session('notif'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>
	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<!-- Jasny -->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
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
			$('.i-checks').iCheck({
			    radioClass: 'iradio_square-green',
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
			<h2>Usuarios</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Usuarios</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<a href="{{ route('crear_usuario') }}" class="ladda-button ladda-button-demo btn btn-primary" data-style="zoom-in"> Nuevo usuario</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Seleccione sus opciones de carga</h5>
					</div>
					<div class="ibox-content">
						@if ($errors->has('error_csv'))
							<div class="alert alert-info">
								{{ $errors->first('error_csv') }}
							</div>
						@endif
						@if (session('no_creados'))
							<div class="alert alert-warning">
								<h4>Información repedita</h4>
								<p>La siguiente información no se ha almacenado en la base de datos debido a que ya existe, por favor verifique su archivo y vuelva a intentarlo</p>
								<ul>
									@foreach (session('no_creados') as $key)
										<li>{{ $key['nombre'] }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if (session('nocreado'))
							<div class="alert alert-warning">
								<h4>No hemos creado estos registros</h4>
								<p>La siguiente información no se ha almacenado en la base de datos debido a que no se encuentra informacion, verifique la tabla y compruebe la infomración</p>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example">
										<thead>
											<th>Cédula</th>
											<th>Nombre</th>
											<th>Faltantes o no encontrado</th>
											<th>Información sumistrada</th>
										</thead>
										<tbody>
											@foreach (session('nocreado') as $key)
												<tr>
													<td>{{ $key['cedula'] }}</td>
													<td>{{ $key['nombre'] }}</td>
													<td>{{ $key['faltantes'] }}</td>
													<td>{{ $key['suministrado'] }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif

						<form action="{{ route('procesar_om') }}" method="post" enctype="multipart/form-data">
							{{  csrf_field() }}
							<label for="">Seleccionar el archivo</label>
							<div class="fileinput fileinput-new input-group" data-provides="fileinput">
								<div class="form-control" data-trigger="fileinput">
									<i class="glyphicon glyphicon-file fileinput-exists"></i>
									<span class="fileinput-filename"></span>
								</div>
								<span class="input-group-addon btn btn-default btn-file">
									<span class="fileinput-new"> <i class="fa fa-search"></i> Seleccionar un archivo</span>
									<span class="fileinput-exists"><i class="fa fa-repeat"></i> Cambiar</span>
									<input type="file" name="archivo" accept="text/csv, .csv"/>
								</span>
								<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Quitar</a>
							</div>
							<div class="form-group">
								<label for="">Tipo de carga</label>
								<br>
								<div class="radio-inline i-checks">
									<label > <input type="radio" value="coords" name="tipo"> <i></i> Coordinación </label>
								</div>
								<div class="radio-inline i-checks">
									<label > <input type="radio" value="cargo" name="tipo" > <i></i> Cargos </label>
								</div>
								<div class="radio-inline i-checks">
									<label > <input type="radio" value="trabajador" name="tipo" > <i></i> Trabajadores </label>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Subir y procesar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
