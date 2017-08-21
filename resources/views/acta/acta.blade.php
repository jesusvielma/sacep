@extends('layouts.acta')
@section('content')
	<div class="body-acta">
		<div class="m-t-lg">
            <div class="row">
                <div class="col-xs-12">
                    <h1 style="text-align: center">Acta de @lang('acta.tipo.'.$acta->tipo)</h1>
                    <p style="text-align: justify">
                        En Mérida, a los @lang('acta.fechas.'.$acta->fecha->format('d')) ({{ $acta->fecha->format('d') }}) días del {{ ucfirst($acta->fecha->formatLocalized('%B')) }} de dos mil @lang('acta.fechas.'.$acta->fecha->format('y')) (20{{$acta->fecha->format('y')}}), siendo las {{ $acta->fecha->format('h:i a') }}, reunidos en {{ $acta->lugar }} del Sistema Teleférico de Mérida Mukumbarí, el(la) ciudadano(a) {{ $sancionador->nombre_completo }}, cédula de identidad V.- {{ $sancionador->cedula_empleado }}, actuando con el carácter de {{ $sancionador->cargo->nombre }}, procede a levantar la presente Acta a los fines de dejar constancia del los siguiente hechos: El(la) ciudadano(a), {{ $sancionado->nombre_completo }}, venezolano, mayor de edad, cédula de identidad   V.- {{ $sancionado->cedula_empleado }}, trabajador(a) que ejerce funciones como {{ $sancionado->cargo->nombre }},  {{ $acta->descripcion }}, es decir, sin que hasta el momento de levantar la presente Acta el precitado trabajador haya informado o notificado a su Jefe inmediato sobre las causas, razones o motivos de su {{ $acta->palabra_clave }}, que le justifiquen dejar de realizar sus labores habituales. Situación que motiva una causa justificada de despido, establecido en el artículo {{ $articulo->identificador }} de la {{ $articulo->ley }}, la cual establece:
                    </p>
                    <blockquote >
                        <p>
                            @foreach ($acta->articulos as $articulo)
                                @if ($articulo->tipo !='articulo')
                                    {{ ucfirst($articulo->tipo) }} {{ $articulo->identificador }} {!! $articulo->contenido !!}
                                @endif
                            @endforeach
                        </p>
                    </blockquote>
                    <p style="text-align: justify">
                        Del hecho arriba descrito son testigos los ciudadanos, {{ $testigo1->nombre_completo }}, titular de la cédula de identidad V-{{ $testigo1->cedula_empleado }} y {{ $testigo2->nombre_completo }}, titular de la cédula de identidad V-{{ $testigo2->cedula_empleado}} respectivamente, quienes laboran en esta empresa.  De la presente Acta se levantan dos (2) ejemplares de un mismo tenor y a un solo efecto, uno será entregado al trabajador(a) {{ $sancionado->nombre_completo }}, arriba identificado, y uno será remitido a la Coordinación de Gestión Humana a los fines legales correspondientes.  Firman.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <br>
                    <span>____________________________</span><br>
                    <span>{{ $sancionador->nombre_completo }}</span><br>
                    <span>Coordinador(a)</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3>Testigos</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-5">
                    <span>____________________________</span><br>
                    <span>{{ $testigo1->nombre_completo }}</span><br>
                    <span>CI {{ $testigo1->cedula_empleado }}</span>
                </div>

                <div class="col-xs-5">
                    <span>____________________________</span><br>
                    <span>{{ $testigo2->nombre_completo }}</span><br>
                    <span>CI {{ $testigo2->cedula_empleado }}</span>
                </div>
            </div>
		</div>
    </div>
@endsection
