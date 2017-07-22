@extends('layouts.main')
@section('title')
	Configuraciones | Listado de Cargos
@endsection

@section('css')
	@if (session('notif') || $errors->has('nombre'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
@endsection

@section('js')
	@if (session('notif') || $errors->has('nombre'))
		<!-- Toastr script -->
	    <script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>
		<script>
			toastr.options = {
			  "progressBar": false,
			  "positionClass": "toast-top-center",
			}
			@if (session('notif'))
				toastr.{{ session('notif.type')}}('{{ session('notif.msg') }}','{{ session('notif.title') }}')
			@else
				toastr.error('{{ $errors->first('nombre') }}','Ha ocurrido un error')
			@endif
		</script>
	@endif
	<script>
		$(document).ready(function () {
			$('.update-cargo').click(function () {
				var row = $(this).parents('tr')
				var id= row.data('id');
				var url = '{{ route('cargo_editar',['id'=>':id']) }}';
				url = url.replace(':id',id);
				$.get(url,function (data) {
					$('#editar_cargo').val(data);
					var form = $('#form_editar');
					var url_update = form.attr('action');
					var url_update = url_update.replace(':CARGO_ID',id);
					form.attr('action',url_update);
				});
			});
		})
	</script>
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-9">
			<h2>Inicio</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}">Inicio </a></li>
				<li class="active">
					<strong>Cargos</strong>
				</li>
			</ol>
		</div>
		<div class="col-sm-3">
			<div class="title-action">
				<a href="#crear" data-toggle="modal" class="btn btn-primary"> Nuevo cargo</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if (count($cargos)>0)
				<div class="col-lg-6 col-lg-offset-3">
					<div class="ibox float-e-margins">
						<div class="ibox-content">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($cargos as $c)
										<tr data-id="{{ $c->id_cargo }}">
											<td>{{ $c->nombre }}</td>
											<td>
												<button data-toggle="modal" data-target="#editar" type="button" class="btn btn-xs btn-success update-cargo"> <i class="fa fa-pencil"></i>
												</button>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							{{ $cargos->links() }}
						</div>
					</div>
				</div>
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no ha información sobre cargos te invitamos a crear uno nuevo.</p>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo cargo</p>
					</div>
				</div>
			@endif
		</div>
	</div>
	<div id="crear" class="modal fade" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="m-t-none m-b">Nuevo cargo</h3>
							<form role="form" action="{{ route('guardar_cargo') }}" method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<label>Nombre del cargo</label>
									<input type="text" name="nombre" placeholder="Ingrese el nombre del cargo" class="form-control">
								</div>
								<div>
									<button class="btn btn-primary pull-right m-t-n-xs" type="submit">Guardar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="editar" class="modal fade" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="m-t-none m-b">Nuevo cargo</h3>
							<form role="form" action="{{ route('cargo_update',['id'=>':CARGO_ID']) }}" method="post" id="form_editar">
								{{ csrf_field() }}
								{{ method_field('PUT')}}
								<div class="form-group">
									<label>Nombre del cargo</label>
									<input type="text" id="editar_cargo" name="nombre" placeholder="Ingrese el nombre del cargo" class="form-control">
								</div>
								<div>
									<button class="btn btn-primary pull-right m-t-n-xs" type="submit">Guardar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
