@extends('layouts.main')
@section('title')
	Evaluar a {{ $empleado->nombre_completo }}
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('"css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/ionRangeSlider/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css')}}" rel="stylesheet">
	<style >
		.wizard > .content {
			background: #FFF;
			border: 1px solid black;
		}
	</style>
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
	<!-- Date range picker -->
    <script src="{{ URL::asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>

	<!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ URL::asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

	<!-- Steps -->
    <script src="{{ URL::asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

	<!-- IonRangeSlider -->
    <script src="{{ URL::asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js')}}"></script>

	<script>
         $(document).ready(function(){
			$("#form").steps({
                bodyTag: "div",
				titleTemplate: '#title#',
				labels: {
			        cancel: "Cancelar",
			        current: "current step:",
			        pagination: "Paginación",
			        finish: "Enviar Evaluación",
			        next: "Siguiente",
			        previous: "Anterior",
			        loading: "Cargando ..."
				},
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
			var date = moment().format('YYYY-MM-DD');
			$('#data_5 .input-daterange').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                autoclose: true,
				language: 'es',
				format: 'yyyy-mm-dd',
				endDate: date
            });
			//moment.locale('es');
			$('#fe').val(date);
			$('.tooltip-demo button').popover();
			$('.range').ionRangeSlider({
				hasGrid: true,
				type: 'single',
	            values: [
	                "Deficiente", "Regular", "Bueno",
					"Muy Bueno", "Excelente"
	            ],
				step:1
	        });

			$('#tipo').change(function(){
				@if(is_object($last_ev))
					var desde = moment("{{ $last_ev->periodo_hasta }}").add(1,'d').format('YYYY-MM-DD');
					var desde_bd = true;
				@else
					var hoy = moment().format('DD');
					var desde_bd = false;
					if(hoy != '01')
					{
						var desde = moment().format('YYYY-MM')+"-01";
					}else{
						var desde = moment().format('YYYY-MM-DD');
					}
				@endif
				var tipo = $(this).val();
				if(tipo == 'mensual'){
					var hasta = moment(desde).add(1,'M').subtract(1,'d').format('YYYY-MM-DD');
				}else if (tipo == 'bimestral') {
					var hasta = moment(desde).add(2,'M').subtract(1,'d').format('YYYY-MM-DD');
					if(moment(hasta).isAfter(date)){
						if(!desde_bd){
							var desde = moment(desde).subtract(1,'M').format('YYYY-MM-DD');
							var hasta = moment(hasta).subtract(1,'M').format('YYYY-MM-DD');
						}else {
							alert('periodo hasta sobre pasa la fecha actual');
							var aux = true;
						}
					}
				}else if (tipo == 'trimestral') {
					var hasta = moment(desde).add(3,'M').subtract(1,'d').format('YYYY-MM-DD');
					if(moment(hasta).isAfter(date)){
						if(!desde_bd){
							var desde = moment(desde).subtract(2,'M').format('YYYY-MM-DD');
							var hasta = moment(hasta).subtract(2,'M').format('YYYY-MM-DD');
						}else {
							alert('periodo hasta sobre pasa la fecha actual');
							var aux = true;
						}
					}
				}else if (tipo == 'semestral') {
					var hasta = moment(desde).add(6,'M').subtract(1,'d').format('YYYY-MM-DD');
					if(moment(hasta).isAfter(date)){
						if(!desde_bd){
							var desde = moment(desde).subtract(5,'M').format('YYYY-MM-DD');
							var hasta = moment(hasta).subtract(5,'M').format('YYYY-MM-DD');
						}else {
							alert('periodo hasta sobre pasa la fecha actual');
							var aux = true;
						}
					}
				}
				else{
					var hasta = moment(desde).add(1,'y').subtract(1,'d').format('YYYY-MM-DD');
				}
				if(desde_bd && aux){
					$(this).val('');
					$('input[name=periodo_desde]').val('');
					$('input[name=periodo_hasta]').val('');
				}else{
					$('input[name=periodo_desde]').val(desde);
					$('input[name=periodo_hasta]').val(hasta);
					$('#data_5 .input-daterange').datepicker('update');
				}
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
						<form action="{{ route('guardar_evaluacion') }}" method="post" id="form" class="wizard-big">
							@include('evaluar.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
