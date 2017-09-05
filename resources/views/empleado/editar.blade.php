@extends('layouts.main')
@section('title')
	Editar información de {{ $empleado->nombre_completo }}
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
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

	<!-- Data picker -->
	<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
	<script src="{{ URL::asset('js/plugins/datapicker/datepicker.es.js')}}"></script>

	<!-- Date range use moment.js same as full calendar plugin -->
	<script src="{{ URL::asset('js/plugins/fullcalendar/moment.min.js')}}"></script>
	<script>
         $(document).ready(function(){

			 $("#form").validate({
 				rules: {
 					nombre_completo: {
 						required: true,
 					},
 					cedula_empleado: {
 						required: true,
 						number: true,
 					},
 					fecha_nacimiento: {
 						required: true,
 						date: true,
 					},
 					fecha_ingreso: {
 						required: true,
 						date: true,
 					},
 					id_cargo:{
 						required: true
 					},
 					id_departamento:{
 						required: true,
 					}
 				}
 			});
 			$('#data_3 .input-group.date').datepicker({
                 startView: 2,
                 todayBtn: "linked",
                 keyboardNavigation: false,
                 forceParse: false,
                 autoclose: true,
 				language: 'es',
 				format: 'yyyy-mm-dd'
             });
 			 $(".dep").select2({
                  placeholder: "Selecciona un departamento",
                  allowClear: true,
              });
 			 $(".cargo").select2({
                  placeholder: "Selecciona un cargo",
                  allowClear: true,
              });
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Empleados</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('empleados') }}"> Empleados </a></li>
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
						<form action="{{ route('update_empleado',['id'=>$empleado->cedula_empleado]) }}" method="post" id="form">
							{{ method_field('PUT') }}
							@include('empleado.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
