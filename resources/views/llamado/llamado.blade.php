@extends('layouts.acta')
@section('content')
	<div class="body-acta">
		<div class="text-right m-b-xl">Mérida, {{ $llamado->fecha->formatLocalized('%d de %B de %Y') }}</div>
		Ciudadano (a)<br>
		<strong>{{ $sancionado->nombre_completo }}<br>
		<span>C.I. {{ $sancionado->cedula_empleado }}</span></strong><br>
		Presente.-
		<h2 class="text-center font-italic text-uppercase">Llamado de atención</h2>
		<p  class="text-justify">
			Me dirijo a usted en la oportunidad de informarle que esta Oficina ha decidido hacerle un llamado de atención, en razón de haber Usted incurrido en <strong>{{ $llamado->descripcion }}</strong>.
		</p>
		<p class="text-justify">
			Se le advierte que este tipo de actuaciones, es considerado falta grave a las obligaciones que impone el contrato de trabajo, y a las políticas y normas internas de la empresa, siendo esta causal de despido justificado.
		</p>
		<p class="text-justify">
			En virtud de lo antes expuesto, le agradecemos tomar los correctivos necesarios, a fin de evitar molestias o sanciones que puedan ocasionar la calificación de falta.
		</p>
		<p class="text-justify">
			Sin más a que hacer referencia, en espera de poder contar con su colaboración al  respecto se despide.
		</p>
		<div class="text-center">
			<span>____________________________</span><br>
			<strong> {{ $sancionador->nombre_completo }} </strong><br>
			{{ $sancionador->cargo->nombre }}<br>
			<strong>Sistema Teleférico de Mérida</strong>

		</div>
	</div>
@endsection
