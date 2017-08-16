@extends('layouts.main')
@section('title')
	Crear un nuevo material para {{ $departamento->nombre }}
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
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

	<!-- TouchSpin -->
	<script src="{{ URL::asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>

	<script>
         $(document).ready(function(){
			$("#form").validate({
				rules: {
					nombre: {
						required: true,
					},
					cantidad: {
						required: true,
						number: true,
					},
				}
			});
			$(".touchspin2").TouchSpin({
				max: 1000,
                step: 1,
                decimals: 0,
                buttondown_class: 'btn btn-danger',
                buttonup_class: 'btn btn-primary'
            });
			$( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Materiales</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('materiales') }}"> Materiales del departamento: {{ Auth::user()->empleado->departamento->nombre }} </a></li>
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
						<h5>Crear</h5>
					</div>
					<div class="ibox-content">
						<form action="{{ route('guardar_material') }}" method="post" id="form">
							@include('material.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
