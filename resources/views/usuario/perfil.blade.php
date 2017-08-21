@extends('layouts.main')
@section('title')
	Perfil de usuario
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
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
			})
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
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			<div class="col-md-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Mi Perfil</h5>
					</div>
					<div>
						<form action="{{ route('update_usuario',['id'=>$usuario->id_usuario]) }}" method="post" id="form" enctype="multipart/form-data">
						<div class="ibox-content no-padding border-left-right text-center">
							@if ($errors->has('avatar'))
								<div class="alert alert-warning">
									{{ $errors->first('avatar')}}
								</div>
							@endif
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 128px; height: 128px;">
							    	<img alt="{{ $usuario->nombre }}" class="img-responsive center-block" src="{{ isset($usuario->avatar) ? asset('storage/avatar/'.$usuario->avatar) : asset('img/profile.jpg') }}">
							 	</div>
							  	<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
							  	<div>
							    	<span class="btn btn-default btn-file"><span class="fileinput-new">Seleciona una imagen</span><span class="fileinput-exists">Cambiar</span><input type="file" name="avatar" value="{{ old('avatar',(isset($usuario->avatar) ? $usuario->avatar :  NULL)) }}" accept=".png, .jpg, .jpeg"></span>
							    	<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Quitar</a>
							  </div>
							  <span class="help-block m-b-none font-bold">Su imagen debe tener 128px X 128px</span>
							</div>

						</div>
							<div class="ibox-content profile-content">
								<h4>Nombre del perfil: <strong>{{ $usuario->nombre }}</strong></h4>
								<h4>Nombre completo: <strong>{{ $usuario->empleado->nombre_completo }}</strong></h4>
								<p><i class="fa fa-birthday-cake"></i> {{ setlocale(LC_ALL,'es,ES_es,ES_ve') }}
									{{ $usuario->empleado->fecha_nacimiento->formatLocalized('%A %e de %B de %Y') }}</p>
								<h5>
									Sobre mi
								</h5>
								<p>
									Estoy ubicado en la {{ $usuario->empleado->departamento->tipo }} <i class="fa fa-building"></i> {{ $usuario->empleado->departamento->nombre }} ocupo el puesto de {{ $usuario->empleado->cargo->nombre }} ingrese a la empresa el {{ $usuario->empleado->fecha_ingreso->formatLocalized('%A %e de %B de %Y') }}
								</p>
								{{-- <div class="user-button">
									<div class="row">
										<div class="col-md-6">
											<button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message</button>
										</div>
										<div class="col-md-6">
											<button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</button>
										</div>
									</div>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Cambiar perfil</h5>
						</div>
						<div class="ibox-content">
								{{ method_field('PUT') }}
								{{ csrf_field() }}
								<div class="form-group {{ $errors->has('trabajador') ? 'has-error' : ''}}">
									<label for="trabajador">Su nombre completo</label>
									<input value="{{ $usuario->empleado->nombre_completo }}" type="text" readonly class="form-control">
								</div>
								<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
									<label for="nombre">Su nombre de usuario</label>
									<div class="row">
										<div class="tooltip-demo col-lg-12">
											<input type="text" name="nombre" value="{{ old('nombre',isset($usuario->nombre) ? $usuario->nombre : NULL) }}" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Se recomienda utilizar un nommbre compuesto del Primer Nombre y Primer Apellido">
										</div>
										@if ($errors->has('nombre'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('nombre') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group">
									<label for="correo">Correo electrónico</label>
									<input type="email" name="correo" class="form-control" required value="{{ old('correo',isset($usuario->correo) ? $usuario->correo : NULL ) }}">
									@if ($errors->has('correo'))
										<span class="help-block m-b-none">
											<strong>{{ $errors->first('correo') }}</strong>
										</span>
									@endif
								</div>
								<div class="form-group">
									<label for="clave">Clave</label>
									<input type="password" name="clave" class="form-control" value="{{ old('clave') }}" {{ isset($usuario) ? NULL : 'required'}}>
									@if ($errors->has('clave'))
										<span class="help-block m-b-none">
											<strong>{{ $errors->first('clave') }}</strong>
										</span>
									@endif
								</div>
								<input type="hidden" name="estado" value="{{ $usuario->estado }}">
								<input type="hidden" name="nivel" value="{{ $usuario->nivel }}">
								<input type="hidden" name="perfil" value="1">
								<div class="form-group">
									<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in" id="form_submit">Guardar </button>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
