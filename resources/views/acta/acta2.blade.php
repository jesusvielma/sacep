@extends('layouts.acta')
@section('content')
	<div class="body-acta">
		<h2 style="text-align: center">Acta <!--de @lang('acta.tipo.'.$acta->tipo)--></h2>
		<p style="text-align: justify">
			En Mérida, a los @lang('acta.fechas.'.$acta->fecha->format('d')) ({{ $acta->fecha->format('d') }}) días del {{ ucfirst($acta->fecha->formatLocalized('%B')) }} de dos mil @lang('acta.fechas.'.$acta->fecha->format('y')) (20{{$acta->fecha->format('y')}}), siendo las {{ $acta->fecha->format('h:i a') }}, reunidos en {{ $acta->lugar }} del Sistema Teleférico de Mérida Mukumbarí, el(la) ciudadano(a) {{ $sancionador->nombre_completo }}, cédula de identidad V.- {{ $sancionador->cedula_empleado }}, actuando con el carácter de {{ $sancionador->cargo->nombre }}, procede a levantar la presente Acta a los fines de dejar constancia del los siguiente hechos: El(la) ciudadano(a), {{ $sancionado->nombre_completo }}, venezolano, mayor de edad, cédula de identidad   V.- {{ $sancionado->cedula_empleado }}, trabajador(a) que ejerce funciones como {{ $sancionado->cargo->nombre }},  {{ $acta->descripcion }}, es decir, sin que hasta el momento de levantar la presente Acta el precitado trabajador haya informado o notificado a su Jefe inmediato sobre las causas, razones o motivos de su {{ $acta->palabra_clave }}, que le justifiquen dejar de realizar sus labores habituales. Situación que motiva una causa justificada de despido, establecido en el artículo {{ $articulo->identificador }} de la {{ $articulo->ley }}, la cual establece:
		</p>
		<blockquote >
			@php
			$count = 0;
			@endphp
			@foreach ($acta->articulos as $articulo)
				@if ($articulo->tipo !='articulo')
					<strong> {{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} </strong> {!! strip_tags($articulo->contenido,'<b><i><u><ul><ol><li><style>') !!}
					@php
						$count = $count + strlen(strip_tags($articulo->contenido))
						@endphp
				@endif
			@endforeach
		</blockquote>
		<p style="text-align: justify">
			Del hecho arriba descrito son testigos los ciudadanos, {{ $testigo1->nombre_completo }}, titular de la cédula de identidad V-{{ $testigo1->cedula_empleado }} y {{ $testigo2->nombre_completo }}, titular de la cédula de identidad V-{{ $testigo2->cedula_empleado}} respectivamente, quienes laboran en esta empresa.  De la presente Acta se levantan dos (2) ejemplares de un mismo tenor y a un solo efecto, uno será entregado al trabajador(a) {{ $sancionado->nombre_completo }}, arriba identificado, y uno será remitido a la Coordinación de Gestión Humana a los fines legales correspondientes.
		</p>
		@if ($count<500)
			Firman.
			<br>
			<div class="text-center">
				<span>____________________________</span><br>
				<span><strong> {{ $sancionador->nombre_completo }} </strong></span><br>
				<span>{{ $sancionador->cargo->nombre }}</span>
			</div>
			<br>
			<h3 class="text-center">Testigos </h3>
			<div class="text-center">
				<div class="col-xs-5">
					<span>_______________________</span><br>
					<span><strong> {{ $testigo1->nombre_completo }} </strong></span><br>
					<span>{{ $testigo1->cargo->nombre }}</span><br>
					<span>CI {{ $testigo1->cedula_empleado }}</span>
				</div>
				<div class="col-xs-5">
					<span>_______________________</span><br>
					<span><strong> {{ $testigo2->nombre_completo }} </strong></span><br>
					<span>{{ $testigo2->cargo->nombre }}</span><br>
					<span>CI {{ $testigo2->cedula_empleado }}</span>
				</div>
			</div>
		@endif
	</div>
	@if ($count>500)
		<div class="other-page">
			Firman.
			<br>
			<div class="text-center">
				<span>____________________________</span><br>
				<span><strong> {{ $sancionador->nombre_completo }} </strong></span><br>
				<span>{{ $sancionador->cargo->nombre }}</span>
			</div>
			<br>
			<h3 class="text-center">Testigos</h3>
			<div class="text-center">
				<div class="col-xs-5">
					<span>_______________________</span><br>
					<span><strong> {{ $testigo1->nombre_completo }} </strong></span><br>
					<span>{{ $testigo1->cargo->nombre }}</span><br>
					<span>CI {{ $testigo1->cedula_empleado }}</span>
				</div>
				<div class="col-xs-5">
					<span>_______________________</span><br>
					<span><strong> {{ $testigo2->nombre_completo }} </strong></span><br>
					<span>{{ $testigo2->cargo->nombre }}</span><br>
					<span>CI {{ $testigo2->cedula_empleado }}</span>
				</div>
			</div>
		</div>
	@endif
@endsection
