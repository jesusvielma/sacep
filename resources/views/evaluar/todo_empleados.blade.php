@extends('layouts.main')
@section('title')
	Evaluaciones / Consultado de trabajadores
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	@if (session('notif'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
	<style >
		mark {
			background-color: #23c6c8;
			padding: .2em;
			color: white;
			border-radius: 5px;
		}
	</style>
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{ URL::asset('js/plugins/markjs/jquery.mark.js')}}"></script>
	<script>
		$(document).ready(function () {
			var l = $('.ladda-button-demo').ladda();

	        l.click(function(event){
	            l.ladda('start');
	        });

			$('#form_submit').click(function (event) {
				event.preventDefault();
				$('#form').submit();
			});

			@foreach ($deps as $dep)
			$('.table-{{ $dep->id_departamento }}').DataTable({
				pageLength: 10,
				responsive: true,
				language: {
					url : '{{ URL::asset('js/plugins/dataTables/i18n/es.json') }}',
				},
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			});
			@endforeach
			$('').DataTable({
                pageLength: 10,
                responsive: true,
				language: {
					url : '{{ URL::asset('js/plugins/dataTables/i18n/es.json') }}',
				},
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
				columns :[
					null,
					null,
					null,
					null,
					null,
					null,
					{"orderable":false},
					{"orderable":false},
				],
            });
			$('.i-checks').iCheck({
			    checkboxClass: 'icheckbox_square-green',
			});

  	 		var $search = $('.search > div'), $input = $("input[name='busqueda']");
			$input.on('input',function (){
				var term = $(this).val();
				$search.show().unmark();
				if (term) {
					$search.mark(term, {
						separateWordSearch: false,
						diacritics: false,
						"exclude": [
							".ibox-content *"
						],
						done: function (e) {
							$search.not(':has(mark)').hide();
							if (e>1) {
								$('#notMatch').removeClass('fadeIn').addClass('hide');
							}
						},
						noMatch: function () {
							$('#notMatch').removeClass('hide').addClass('fadeIn');
						}
					})
				}
			});
			$('.borrar_busqueda').click(function () {
				$search.show().unmark();
				$input.val('').focus();
				$('#notMatch').removeClass('fadeIn').addClass('hide');
			});
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
			<h2>Listado de coordinaciones/Unidades</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('index_evaluar') }}"> Listado de trabajadores a evaluar </a></li>
				<li class="active">
					<strong>Coordinaciones/Unidades con sus trabajadores</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<input type="text" name="busqueda" placeholder="Buscar coordinación o unidad" class="form-control">
					<span class="input-group-btn"><button class="btn btn-warning borrar_busqueda"><i class="fa fa-times"></i></button></span>
				</div>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row hide animated " id="notMatch">
			<div class="col-lg-6 col-lg-offset-3">
				<div class="alert alert-info">
					<h4>No hay resultados</h4>
					<p>La búsqueda realizado no presenta resultado, por favor verifíquela y vuela a intentarlo</p>
					<button class="btn btn-warning btn-block borrar_busqueda"><i class="fa fa-times"></i> Borrar y reiniciar la búsqueda</button>
				</div>
			</div>
		</div>
		<div class="row search">
			@foreach ($deps as $dep)
				<div class="col-lg-6">
					<div class="ibox collapsed">
						<div class="ibox-title">
							<h5>{{ $dep->nombre }}</h5>
							<div class="ibox-tools">
								<a class="collapse-link" data-toggle="tooltip" data-placement="top" title="" data-original-title="Muestra o esconde la información del factor">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							@if ($dep->empleados->count())
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover table-{{$dep->id_departamento}}">
										<thead>
											<tr>
												<th>Cédula</th>
												<th>Nombre completo</th>
												<th>Cargo</th>
												<th style="width:10%">Acciones</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($dep->empleados as $empleado)
												<tr>
													<td>{{ $empleado->cedula_empleado }}</td>
													<td>{{ $empleado->nombre_completo }}</td>
													<td>{{ $empleado->cargo->nombre }}</td>
													<td class="tooltip-demo">
														<a href="{{ route('evaluaciones',['id'=>$empleado->cedula_empleado]) }}" data-toggle='tooltip' data-placament='top' data-title= 'Ver evaluaciones de {{ $empleado->nombre_completo }}' class="btn btn-success btn-xs"><i class="fa fa-list"></i></a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@else
								<div class="alert alert-info">
									<h4>Opps!</h4>
									<p>Esta coordinación o unidad no tiene trabajadores</p>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endforeach

		</div>
	</div>

@endsection
