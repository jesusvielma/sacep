@extends('layouts.main')
@section('title')
	Crear un nuevo departamento
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
	<!-- Select2 -->
    <script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
         $(document).ready(function(){
			$("#form").validate({
				rules: {
					nombre: {
						required: true,
						maxlength: 60
					},
					responsable: {
						required: true,
					}
				}
			});
			 $(".responsable").select2({
                 placeholder: "Selecciona un responsable",
                 allowClear: true
             });
			 $( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
			 $('.i-checks').iCheck({
				 radioClass: 'iradio_square-green',
			 });

			$('#otro').click(function () {
				var id_row = $('.row').last().data('row');
				id_row++;
				var html = '<div class="row" data-row="'+id_row+'">';
						html+= '<div class="col-lg-4">';
							html+= '<div class="form-group">';
								html+= '<label for="nombre">Nombre</label>';
								html+= '<input type="text" name="campos['+id_row+'][nombre]" class="form-control">';
							html+= '</div>';
						html+= '</div>';
						html+= '<div class="col-lg-5">';
							html+= '<div class="form-group">';
								html+= '<label for="nombre">Visibilidad</label><br>';
								html+= '<div class="radio-inline i-checks"><label > <input type="radio" value="ambos" name="campos['+id_row+'][visibilidad]" id="activo"> <i></i> Ambos </label> </div>';
								html+= '<div class="radio-inline i-checks"> <label > <input type="radio" value="coordinador" name="campos['+id_row+'][visibilidad]" id="inactivo"> <i></i> Coordinador </label></div>';
								html+= '<div class="radio-inline i-checks"><label > <input type="radio" value="trabajador" name="campos['+id_row+'][visibilidad]" id="inactivo"> <i></i> Trabajador </label></div>';
							html+= '</div>';
						html+= '</div>';
						html+= '<div class="col-lg-3"><div class="form-group"><label for="nombre">Nombre del departamento</label><textarea name="campos['+id_row+'][informacion]" class="form-control" ></textarea></div></div>';
					html+= '</div>';

					var row = $('.row').last();
					row.after(html);
					$('.i-checks').iCheck({
	   				 radioClass: 'iradio_square-green',
	   			 });
			});
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Departamentos</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('departamento.index') }}"> Departamentos </a></li>
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
			<div class="col-lg-10 col-lg-offset-1">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Crear</h5>
					</div>
					<div class="ibox-content">
						<form action="{{ route('guardar_item') }}" method="post" id="form">
							{{ csrf_field() }}
							<input type="hidden" name="id_factor" value="{{ $factor }}">
							<div class="row" data-row="0">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="nombre">Nombre</label>
										<input type="text" name="campos[0][nombre]" class="form-control">
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label for="nombre">Visibilidad</label>
										<br>
										<div class="radio-inline i-checks">
											<label > <input type="radio" value="ambos" name="campos[0][visibilidad]" id="activo"> <i></i> Ambos </label>
										</div>
										<div class="radio-inline i-checks">
											<label > <input type="radio" value="coordinador" name="campos[0][visibilidad]" id="inactivo"> <i></i> Coordinador </label>
										</div>
										<div class="radio-inline i-checks">
											<label > <input type="radio" value="trabajador" name="campos[0][visibilidad]" id="inactivo"> <i></i> Trabajador </label>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="nombre">Nombre del departamento</label>
										<textarea name="campos[0][informacion]" class="form-control" ></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-info" id="otro">Otro Item</button>
								<button type="submit" class="ladda-button ladda-button-demo btn btn-success " data-style="zoom-in">Guardar </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
