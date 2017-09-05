@extends('layouts.main')
@section('title')
	Editar el @lang('enums.departamento'.$dep->tipo) {{ $dep->nombre }}
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
	<script src="{{ URL::asset('js/plugins/validate/additional-methods.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/validate/messages_es.js') }}"></script>
	<!-- Select2 -->
    <script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
         $(document).ready(function(){

             $("#form").validate({
                 rules: {
                     nombre: {
                         required: true,
                         maxlength: 60,
						 letraspuntacion: true
                     },
                     responsable: {
                         required: true,
                     },
 					tipo: {
 						required: true
 					}
                 }
             });
			 $(".responsable").select2({
                 placeholder: "Selecciona un responsable",
                 allowClear: true
             });
			 $(".depto").select2({
 				placeholder: "Selecciona un coordinación padre",
 				allowClear: true
 			});
 		   $('.i-checks').iCheck({
 			   radioClass: 'iradio_square-green',
 		   });
 		   $('#unidad').on('ifChecked', function(){
 			   $(".depto").prop("disabled", false);
 		   });
 		   $('#coord').on('ifChecked', function(){
 			   $(".depto").prop("disabled", true);
 		   });
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Coordinación/Unidad</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('departamento.index') }}"> Coordinación/Unidad </a></li>
				<li class="active">
					<strong>Editar</strong>
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
						<form action="{{ route('departamento.update',['id'=>$dep->id_departamento]) }}" method="post" id="form">
							{{ method_field('PUT') }}
							@include('departamento.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
