@extends('layouts.main')
@section('title')
	Crear un nuevo usuario
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

	<!-- Jquery Validate -->
    <script src="{{ URL::asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/validate/messages_es.js') }}"></script>
	<!-- Select2 -->
    <script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
         $(document).ready(function(){
			$("#form").validate({
				rules: {
					clave: {
						minlength: 7
					}
				}
			});
			 $(".trabajador").select2({
                 placeholder: "Selecciona un trabajador",
                 allowClear: true
             });
			 $( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
			 $('#trabajador').change(function () {
			 	var nombre = $('#trabajador option:selected').text();
				$('input[name=nombre]').val(nombre);
			});
			$('#editar_nombre').click(function () {
				$('input[name=nombre]').attr('readonly',false);
				$('.tooltip-demo').removeClass('col-lg-11').addClass('col-lg-12');
				$(this).remove();
			});
			$('.i-checks').iCheck({
				radioClass: 'iradio_square-green',
			});
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Usuarios</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('usuarios') }}"> Usuarios </a></li>
				<li class="active">
					<strong>Crear</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">

		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Registrar nuevo usuario</h5>
					</div>
					<div class="ibox-content">
						<form action="{{ route('guardar_usuario') }}" method="post" id="form">
							@include('usuario.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
