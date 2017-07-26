@extends('layouts.main')
@section('title')
	Listado de usuarios
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
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
	<script>
		$(document).ready(function () {
			var l = $('.ladda-button-demo').ladda();

	        l.click(function(event){
	            l.ladda('start');
	        });

			$('#form_submit').click(function (event) {
				event.preventDefault();
				$('#form').submit();
			})
		});
	</script>
	@if (session('notif'))
		<!-- Toastr script -->
	    <script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>
		<script>
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
			@if ($usuarios->count())
				<div class="col-lg-10 col-lg-offset-1">
					<div class="ibox">
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Empleado</th>
											<th>Nombre</th>
											<th>Correo</th>
											<th>Nivel</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($usuarios as $usuario)
											<tr>
												<td>{{ $usuario->empleado ? $usuario->empleado->nombre_completo : 'No asociado a un empleado' }}</td>
												<td>{{ $usuario->nombre }}</td>
												<td>{{ $usuario->correo }}</td>
												<td>@lang('enums.usuario.'.$usuario->nivel)</td>
												<td>
													<a class="btn btn-success btn-xs" href="{{ route('editar_usuario',['id'=>$usuario->id_usuario]) }}"><i class="fa fa-pencil"></i></a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							{{ $usuarios->links() }}
						</div>
					</div>
				</div>
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no ha información sobre departamentos te invitamos a crear uno nuevo.</p>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo departamento</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
