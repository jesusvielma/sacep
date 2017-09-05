@extends('layouts.main')
@section('title')
	Editar llamado de atención
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

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
    <script src="{{ URL::asset('js/plugins/select2/select2.full.js') }}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>

	<!-- Word/Char counter -->
    <script src="{{ URL::asset('js/bootstrap-maxlength.js')}}"></script>

	<!-- Dual Listbox -->
    <script src="{{ asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')}}"></script>
	<script>
         $(document).ready(function(){
			 $("#form").validate({
 				rules: {
 					descripcion: {
 						required: true,
 						maxlength: 500
 					}
 				}
 			});
 			$('#editor').maxlength({
 			    alwaysShow: true,
 			    threshold: 50,
 			    warningClass: "label label-primary",
 			    limitReachedClass: "label label-danger",
 			    placement: 'top',
 			    preText: 'Caracteres usados ',
 			    separator: ' de ',
 			});
 			$('.i-checks').iCheck({
 				radioClass: 'iradio_square-green',
 			});
			$( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Trabajadores - Actas y Llamados de atención</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('actas') }}">Trabajadores - Actas y Llamados de atención </a></li>
				<li class="active">
					<strong>Editar llamado</strong>
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
						<h5>Editar</h5>
					</div>
					<div class="ibox-content">
						<form action="{{ route('update_llamado',['id'=>$llamado->id_acta]) }}" method="post" id="form" class="form-horizontal">
							{{ method_field('PUT') }}
							@include('llamado.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
