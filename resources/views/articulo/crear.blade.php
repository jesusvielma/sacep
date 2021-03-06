@extends('layouts.main')
@section('title')
	Registrar nuevo articulo
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	<link href="{{ asset('css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

	<!-- Jquery Validate -->
    <script src="{{ URL::asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/validate/additional-methods.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/validate/messages_es.js') }}"></script>
	<!-- Select2 -->
    <script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>

	<!-- SUMMERNOTE -->
	<script src="{{ asset('js/plugins/summernote/summernote.min.js')}}"></script>
	<script src="{{ asset('js/plugins/summernote/summernote-es-ES.js')}}"></script>

	<script>
         $(document).ready(function(){
			$("#form").validate({
				rules: {
					identificador: {
						required: true,
					},
					contenido: {
						required: true,
					},
					ley: {
						required: true,
						maxlength: 255,
					},
					tipo:{
						required: true,
					}
				}
			});
			$('.i-checks').iCheck({
				radioClass: 'iradio_square-green',
			});
			$('#literal').on('ifChecked', function(){
				$(".padre").prop("disabled", false);
				$('.articulo').prop('disabled',false);
				$('.literal').prop('disabled',true);
				$(".padre").select2({
					placeholder: "Selecciona",
					allowClear: true
				});
			});
			$('#parrafo').on('ifChecked', function(){
				$(".padre").prop("disabled", false);
				$('.literal').prop('disabled',false);
				$('.articulo').prop('disabled',true);
				$(".padre").select2({
					placeholder: "Selecciona",
					allowClear: true
				});
			});
			$('#articulo').on('ifChecked', function(){
				$(".padre").prop("disabled", true);
				$('option').prop('disabled',true);
				$(".padre").select2({
					placeholder: "Selecciona",
					allowClear: true
				});
			});

			$(".padre").select2({
				placeholder: "Selecciona",
				allowClear: true
			});
			$('#editor').summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['para', ['ul', 'ol']],
				],
				placeholder: "Escriba aquí toda la información sobre el articulo/literal/párrafo que esta ingresando. Recuerde este información será mostrada en el acta correspondiente",
				height: 200,
				lang: 'es-ES'
			});
			 $( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Configuraciones</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('articulos') }}"> Configuración / Sanciones  </a></li>
				<li class="active">
					<strong>Crear articulo / literal / párrafo</strong>
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
						<h5>Crear</h5>
					</div>
					<div class="ibox-content">
						<form action="{{ route('guardar_articulo') }}" method="post" id="form">
							@include('articulo.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
