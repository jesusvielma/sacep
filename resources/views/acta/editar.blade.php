@extends('layouts.main')
@section('title')
	Editar acta {{ $acta->tipo }}
@endsection

@section('css')
	<!-- Ladda style -->
    <link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

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
    <script src="{{ URL::asset('js/plugins/select2/select2.full.js') }}"></script>

	<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js')}}"></script>

	<!-- Word/Char counter -->
    <script src="{{ URL::asset('js/bootstrap-maxlength.js')}}"></script>

	<!-- Dual Listbox -->
    <script src="{{ asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')}}"></script>
	<script>
         $(document).ready(function(){
			 $("#form").validate({
 				rules: {
 					descripcion: {
 						required: true,
 						maxlength: 255
 					},
 					palabra_clave: {
 						required: true,
 					},
 					"articulo[]": {
 						required: true,
 						minlength: 1

 					},
 					tipo:{
 						required: true,
 					}
 				}
 			});
 			$('#editor').maxlength({
 			    alwaysShow: true,
 			    threshold: 50,
 			    warningClass: "label label-primary",
 			    limitReachedClass: "label label-danger",
 			    placement: 'top',
 			    preText: 'Caracteres usados ',
 			    separator: ' de ',
 			});
 			$('.i-checks').iCheck({
 				radioClass: 'iradio_square-green',
 			});
 			$( 'button[type=submit]' ).ladda( 'bind', { timeout: 50000 } );
			// var data = [
			// 	@foreach ($articulos as $articulo)
			// 		{ id: '{{ $articulo->id_articulo }}',
			// 		  text: @if (!isset($articulo->padre))
  	// 					'{{ ucfirst($articulo->tipo)}} {{$articulo->identificador}} de <b> {{ $articulo->ley }} </b>'
  	// 				@elseif (isset($articulo->padre) && !isset($articulo->art_padre->padre))
  	// 					'{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del <b>{{ ucfirst($articulo->art_padre->tipo).' '.$articulo->art_padre->identificador }}</b> de <b>{{ $articulo->ley }}</b>'
  	// 				@endif
  	// 				@if (isset($articulo->art_padre->padre))
  	// 					'{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del <b>{{ ucfirst($articulo->art_padre->tipo) }} {{ $articulo->art_padre->identificador }}</b> del <b>{{ ucfirst($articulo->art_padre->art_padre->tipo).' '.$articulo->art_padre->art_padre->identificador }}</b> de <b>{{ $articulo->ley }}</b>'
  	// 				@endif,
			// 		title: '{{ $articulo->tipo }}'
			// 	},
			// 	@endforeach
			// ];
			// $('.articulo').select2({
			// 	data: data,
			// 	 placeholder: "Selecciona los articulos a incluir",
			// 	 allowClear: true,
			// 	 language: 'es',
			// 	 escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            // });
			var lp = [
				@foreach ($articulos as $articulo)
					@if ($articulo->tipo != 'articulo')
						{ id: '{{ $articulo->id_articulo }}',
						  text: @if (!isset($articulo->padre))
	  							'{{ ucfirst($articulo->tipo)}} {{$articulo->identificador}} de <b> {{ $articulo->ley }} </b>'
			  					@elseif (isset($articulo->padre) && !isset($articulo->art_padre->padre))
			  						'{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del <b>{{ ucfirst($articulo->art_padre->tipo).' '.$articulo->art_padre->identificador }}</b> de <b>{{ $articulo->ley }}</b>'
			  					@endif
			  					@if (isset($articulo->art_padre->padre))
			  						'{{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} del <b>{{ ucfirst($articulo->art_padre->tipo) }} {{ $articulo->art_padre->identificador }}</b> del <b>{{ ucfirst($articulo->art_padre->art_padre->tipo).' '.$articulo->art_padre->art_padre->identificador }}</b> de <b>{{ $articulo->ley }}</b>'
			  					@endif,
							title: '{{ ucfirst($articulo->tipo) }}',
							dataid: '{{ $articulo->padre }}',
							disabled: true,
						},
					@endif
				@endforeach
			];

			var art = [
				@foreach ($articulos as $articulo)
					@if ($articulo->tipo == 'articulo')
						{ id: '{{ $articulo->id_articulo }}',
						  text: @if (!isset($articulo->padre))
	  							'{{ ucfirst($articulo->tipo)}} {{$articulo->identificador}} de <b> {{ $articulo->ley }} </b>'
			  					@endif,
							title: '{{ $articulo->tipo }}',
						},
					@endif
				@endforeach
			];

			$('.articulo').select2({
				data: art,
				 placeholder: "Selecciona un articulo",
				 allowClear: true,
				 language: 'es',
				 escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            });

			$('.articulo').change(function () {
				var val = $(this).val();
				$('.articulo1').prop('disabled',false)
				$('.articulo1 option').prop('disabled',true)
				$('.articulo1 option[id='+val+']').prop('disabled',false)
				$('.articulo1').select2({
					placeholder: "Selecciona los literales y párrafos correspondiente con el acta",
	   				allowClear: true,
	   				language: 'es',
	   				escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
				});
			});

			$('.articulo1').select2({
				data: lp,
				 placeholder: "Selecciona los artículos a incluir",
				 allowClear: true,
				 language: 'es',
				 escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            });
			@foreach ($acta->articulos as $art)
			$('.articulo option[value={{$art->id_articulo}}]').prop('selected',true);
			@endforeach
			$('.articulo').select2({
				 placeholder: "Selecciona un articulo",
				 allowClear: true,
				 language: 'es',
				 escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            });

			@foreach ($acta->articulos as $art)
			$('.articulo1 option[value={{$art->id_articulo}}]').prop('selected',true);
			@if ($art->padre)
			$('.articulo1 option[id={{ $art->padre }}]').prop('disabled',false);
			@endif
			@endforeach
			$('.articulo1').select2({
				placeholder: "Selecciona los literales y párrafos correspondiente con el acta",
				allowClear: true,
				language: 'es',
				escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			});
        });
    </script>

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-9">
			<h2>Actas</h2>
			<ol class="breadcrumb">
				<li><a href="{{ route('pagina_inicio') }}"> Inicio </a></li>
				<li><a href="{{ route('actas') }}"> Actas  </a></li>
				<li class="active">
					<strong>Editar acta</strong>
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
						<form action="{{ route('update_acta',['id'=>$acta->id_acta]) }}" method="post" id="form" class="form-horizontal">
							{{ method_field('PUT') }}
							@include('acta.formulario')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
