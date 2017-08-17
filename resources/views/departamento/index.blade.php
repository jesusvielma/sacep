@extends('layouts.main')
@section('title')
	Listado de departamentos
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
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
				<a href="{{ route('departamento.create') }}" class="ladda-button ladda-button-demo btn btn-primary" name="button" data-style="zoom-in"> Nuevo departamento</a>
			</div>
		</div>
	</div>

	<div class="wrapper wrapper-content animated fadeInRightBig">
		<div class="row">
			@if (count($dptos)>0)
				@foreach ($dptos as $dep)
					<div class="col-lg-4">
						<div class="ibox ">
							<div class="ibox-title">
								<h5>{{ $dep->nombre }}</h5>
								<div class="ibox-tools tooltip-demo">
									<a href="{{ route('departamento.edit',['id'=>$dep->id_departamento]) }}" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-pencil"></i></a>
									{{-- <a href="#" id="form_submit"> <i class="fa fa-remove"></i></a>
									<form id="form" action="{{ route('departamento.destroy',['id'=>$dep->id_departamento]) }}" method="post">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form> --}}
								</div>
							</div>
							<div class="ibox-content">
								<h4>Información</h4>
								<dl class="dl-horizontal">
									<dt>Responsable:</dt><dd> {{ isset($dep->encargado->nombre_completo) ? $dep->encargado->nombre_completo : 'Se debe asignar un responsable de esta coordinación o unidad'}} </dd>
									<dt>Cantidad de Empleados: </dt><dd>{{ $dep->empleados()->count() }}</dd>
									<dt>Tipo:</dt> <dd>@lang('enums.departamento.'.$dep->tipo)</dd>
									@if ($dep->departamento_padre)
										<dt>Adscrita a la coordinación: </dt><dd>{{$dep->hijo->nombre}}</dd>
									@else
										<dt>Esta coordinación tiene: </dt><dd>{{$dep->padre()->count()}} unidades</dd>
									@endif
								</dl>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<div class="col-lg-6 col-lg-offset-3">
					<div class="alert alert-info">
						<h4>Oops! No hemos encontrado información</h4>
						<p>Parece que no ha información sobre departamentos te invitamos a crear uno nuevo.</p>
						<p>Le recomendamos usar el botón que se encuentra la parte superior derecha de su pantalla para crear un nuevo departamento</p>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection
