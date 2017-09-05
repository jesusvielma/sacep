@extends('layouts.main')
@section('title')
	Listado de articulos, literales y párrafos
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
	@if (session('notif'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
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

			$('.dataTables-example').DataTable({
                pageLength: 10,
                responsive: true,
				language: {
					url : '{{ URL::asset('js/plugins/dataTables/i18n/es.json') }}',
				},
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
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
			<h2>Configuraciones / Sanciones</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Sanciones - Artículos/Literales/Párrafos</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<a href="{{ route('articulo_nuevo') }}" class="ladda-button ladda-button-demo btn btn-primary" name="button" data-style="zoom-in"> Nuevo articulo</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if ($articulos->count())
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Todos los recursos de sanciones</h5>
							<div class="ibox-tools">
							</div>
						</div>
						<div class="ibox-content">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>Número/Letra</th>
											<th>Contenido</th>
											<th>Ley</th>
											<th>Tipo</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($articulos as $articulo)
											<tr>
												<td>{{ $articulo->identificador }}</td>
												<td>{!! $articulo->contenido !!}</td>
												<td>{{ $articulo->ley }}</td>
												<td>{{ $articulo->tipo }}</td>
												<td class="tooltip-demo">
													<a href="{{ route('editar_articulo',['id'=>$articulo->id_articulo])}}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Editar a {{ $articulo->tipo.' '.$articulo->identificador }}"><i class="fa fa-pencil"></i></a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no hay información sobre artículos, literales o párrafos te invitamos a crear uno nuevo.</p>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo recurso</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
