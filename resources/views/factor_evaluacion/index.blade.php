@extends('layouts.main')
@section('title')
	Listado de Factores de Evaluación
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	@if (session('notif') || $errors->has('nombre') || $errors->has('porcentaje'))
		<!-- Toastr style -->
	    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
	@endif
@endsection

@section('js')
	<!-- Ladda -->
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>
	<!-- TouchSpin -->
    <script src="{{ URL::asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
		$(document).ready(function () {
			$(".touchspin2").TouchSpin({
                min: 0,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%',
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

			$('.update').click(function () {
				var id = $(this).data('id')
				var url = '{{ route('editar_factor',['id'=>':id']) }}';
				url = url.replace(':id',id);
				$.get(url,function (data) {
					$('#nombre_editar').val(data.nombre);
					$('#porcentaje_editar').val(data.porcentaje);
					if(data.estado == 0 ){
						$('#inactivo').attr('checked',true);
					}
					else{
						$('#activo').attr('checked',true);
					}
					$('.i-checks').iCheck({
						radioClass: 'iradio_square-green',
					});
					var form = $('#form_editar');
					var url_update = form.attr('action');
					var url_update = url_update.replace(':ID',id);
					form.attr('action',url_update);
					$('#editar').modal('show');
				});
			});
			$('.scroll_content').slimscroll({
	            height: '300px'
	        })
		});
	</script>
	@if (session('notif') || $errors->has('nombre') || $errors->has('porcentaje') )
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
				toastr.error('{{ $errors->first('nombre') }} {{ $errors->first('porcentaje') }}','Ha ocurrido un error')
			@endif
		</script>
	@endif
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Factores de Evaluación</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Factores de Evaluación</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
				<a href="#crear" data-toggle="modal" class="btn btn-primary"> Nuevo factor</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if (count($factores)>0)
				@foreach ($factores as $factor)
					<div class="col-lg-6">
						<div class="ibox collapsed">
							<div class="ibox-title">
								<h5>{{ $factor->nombre }}
									@if ($factor->items()->count() && $factor->estado == 1)
										<small class="text-success"> En uso
									@elseif ($factor->items()->count() && $factor->estado == 0)
										<small class="text-danger"> No se usa para nuevas evaluaciones
									@elseif ($factor->estado == 1 )
										<small> <span class="text-success">En uso</span> | <span class="text-danger">Sin items</span>
									@else
										<small class="text-danger"> Fuera de uso | Sin items
									@endif
									| {{ $factor->porcentaje > 0 ? 'Valor: '.$factor->porcentaje.'%' : 'Sin valor'}}
									</small>
								</h5>
								<div class="ibox-tools tooltip-demo">
									<a class="collapse-link" data-toggle="tooltip" data-placement="top" title="" data-original-title="Muestra o esconde la información del factor">
		                                <i class="fa fa-chevron-up"></i>
		                            </a>
									<a href="#" class="update" data-id="{{ $factor->id_factor }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar este factor"><i class="fa fa-pencil"></i></a>
									<a href="{{ route('crear_item',['factor'=>$factor->id_factor]) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agrega items a este factor"><i class="fa fa-plus-square"></i></a>
								</div>
							</div>
							<div class="ibox-content">
								<div class="scroll_content">
									<h4>Información</h4>
									@if ($factor->items()->count())
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Visible para</th>
													<th>Información</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($factor->items as $item)
													<tr>
														<td>{{ $item->nombre }}</td>
														<td>{{ $item->visivilidad }}</td>
														<td>{!! $item->informacion !!}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									@else
										<div class="alert alert-info">
											<h4>Oops!</h4>
											<p>No hemos encontrados los item de este factor, puede proceder a hacer clic en simbolo de mas en la parte superior izquierda de esta caja para agregar items de evaluación a este factor.</p>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no ha información sobre factores de evaluación te invitamos a crear uno nuevo.</p>
						<p>Te recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo factor de evaluación</p>
					</div>
				</div>
			@endif
		</div>
		<div id="crear" class="modal inmodal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<form role="form" action="{{ route('guardar_factor') }}" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<i class="fa fa-plus modal-icon"></i>
							<h4 class="modal-title">Nuevo factor de evaluación</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
										{{ csrf_field() }}
										<div class="form-group">
											<label>Nombre del factor</label>
											<input type="text" name="nombre" placeholder="Ingrese el nombre del factor" class="form-control" value="{{ old('nombre') }}">
										</div>
										<div class="form-group">
											<label for="porcentaje">Porcentaje en la evaluación</label>
											<input class="touchspin2" type="text" value="{{old('porcentaje','0')}}" name="porcentaje">
										</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
							<button class="btn btn-primary" type="submit">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="editar" class="modal inmodal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog ">
				<div class="modal-content">
					<form role="form" action="{{ route('update_factor',['id'=>':ID']) }}" method="post" id="form_editar">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<i class="fa fa-pencil modal-icon"></i>
							<h4 class="modal-title">Editar factor de evaluación</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
										{{ csrf_field() }}
										{{ method_field('PUT')}}
										<div class="form-group">
											<label>Nombre del factor</label>
											<input type="text" name="nombre" id="nombre_editar" placeholder="Ingrese el nombre del factor" class="form-control" value="{{ old('nombre') }}">
										</div>
										<div class="form-group">
											<label for="porcentaje">Porcentaje en la evaluación</label>
											<input class="touchspin2" type="text" id="porcentaje_editar" value="{{old('porcentaje','0')}}" name="porcentaje">
										</div>
										<div class="form-group">
											<label for="estado">Estado del factor</label>
											<br>
											<div class="radio-inline i-checks">
												<label > <input type="radio" value="1" name="estado" id="activo"> <i></i> Activo </label>
											</div>
											<div class="radio-inline i-checks">
												<label > <input type="radio" value="0" name="estado" id="inactivo"> <i></i> Inactivo </label>
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
							<button class="btn btn-primary pull-right" type="submit">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
