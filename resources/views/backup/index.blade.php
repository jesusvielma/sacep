@extends('layouts.main')
@section('title')
	Listado de departamentos
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
    <script src="{{ URL::asset('js/plugins/ladda/spin.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>
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
			})

            $('.borrar_b').click(function (event) {
                event.preventDefault();
                var url = $(this).attr('href');
				alert(url);
                var form = $('#form_borrar');
                form.attr('action',url);
                form.submit();
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
			toastr.{{ session('notif.type')}}('{{ session('notif.msg') }}','{{ session('notif.title') }}')
		</script>
	@endif
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Departamentos</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li class="active">
					<strong>Departamentos</strong>
				</li>
			</ol>
		</div>
		<div class="col-lg-3">
			<div class="title-action">
                <form action="{{ route('crear_backup') }}" method="post" id="form">
                    {{ method_field('PUT')}}
                    {{ csrf_field() }}
                    <button type="submit" id="form_submit" class="ladda-button ladda-button-demo btn btn-primary"data-style="zoom-in"> Respaldar</button>
                </form>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if (count($backups)>0)
					<div class="col-lg-12">
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Respaldos</h5>
								<div class="ibox-tools">

								</div>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table class="table table-hover table-condensed dataTables-example">
	                                    <thead>
	                                        <th>#</th>
	                                        <th>Ubicación</th>
	                                        <th>Fecha</th>
	                                        <th class="text-right">Tamaño</th>
	                                        <th class="text-right">Acciones</th>
	                                    </thead>
	                                    <tbody>
	                                        @foreach ($backups as $k => $b)
	                                            <tr>
	                                                <td>{{ $k+1 }}</td>
	                                                <td>{{ $b['disk'].'/'.$b['file_name'] }}</td>
	                                                <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y %I:%M %P') }}</td>
	                                                <td class="text-right">{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
	                                                <td class="text-right">
	                                                    @if ($b['download'])
	                                                    <a class="btn btn-xs btn-default" href="{{ route('descargar_b') }}?disk={{ $b['disk'] }}&path={{ urlencode($b['file_path']) }}&file_name={{ urlencode($b['file_name']) }}"><i class="fa fa-cloud-download"></i> Descargar</a>
	                                                    @endif
	                                                    <a class="btn btn-xs btn-danger borrar_b" data-button-type="delete" href="{{ url('/backup/delete/'.$b['file_name']) }}?disk={{ $b['disk'] }}" ><i class="fa fa-trash-o"></i> Borrar</a>
	                                                </td>
	                                            </tr>
	                                        @endforeach
	                                    </tbody>
									</table>
								</div>
								<form action="#" method="post" id="form_borrar">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
								</form>
							</div>
						</div>
					</div>
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>No se han realizado respaldos.</h4>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo nuevo respaldo</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
