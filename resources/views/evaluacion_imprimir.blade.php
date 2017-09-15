<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Evaluación de {{ $empleado->nombre_completo }} del mes {{ $evaluacion->fecha_evaluacion->formatLocalized('%B de %Y') }}</title>

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<style>
        html, body {
            background: #FFF;
        }
		body {
			margin: 1cm;
			color: black;
            padding: 0
		}
        hr {
            page-break-after: always;
            border: 0;
        }
		#header {
			 position: fixed;
			 top: -10px;
			 left: 1cm;
			 right: 1cm;
             border: 0;
             padding: 0
		}
		.borde-tabla > tbody > tr > td  {
			border: 1px solid black;
		}
		table {
			font-size: 9px
		}
        .bg-success {
            background-color: #0070c1;
            padding: 9px !important;
        }
        .bg-muted {
            background-color: #bfbfbf;
            padding: 7px !important;
        }
        .bg-info {
            background-color: #d8e4bc;
            color: #000000;
            padding: 4px !important;
        }
        .td-no-border-l {
            border: 0 !important;
            border-left: 1px solid !important;
        }
        .td-no-border-r {
            border: 0 !important;
            border-right: 1px solid !important;
        }
        .td-no-border {
            border: 0 !important;
        }
	</style>

</head>

<body class="">
    <div id="header">
        <div class="table-responsive">
            <table class="table table-condensed" >
                <tbody>
                    <tr>
                        <td style="width:10%" class="text-center">
                            <img src="{{ asset('img/logo_ventel.png') }}" alt=""
                            height="50px">
                        </td>
                        <td class="text-center text-uppercase">Republica Bolivariana de Venezuela <br>
                            Ministerio del Poder Popular para el Turismo<br>
                            Venezuelana de Telefericos
                        </td>
                        <td style="width:10%" class="text-center">
                            <img src="{{ asset('img/mukumbari-square.jpg') }}" alt="" style="height:50px">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="">
		<div class="m-t-lg">
			<div class="">
				<table class="table borde-tabla table-condensed">
					<tbody>
						<tr>
							<td colspan="6" class="font-bold text-uppercase bg-success text-center">Hoja de evaluación del trabajador</td>
						</tr>
						<tr>
							<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Datos generales del evaluado</td>
						</tr>
						<tr>
							<td style="padding:2px" colspan="5" class="text-right font-bold">Fecha emision</td>
							<td style="width: 12%; padding:2px">{{ $evaluacion->fecha_evaluacion->format('d-m-Y') }}</td>
						</tr>
						<tr>
							<td style="padding:2px" class="font-bold">Nombres y apellidos </td>
							<td style="padding:2px" colspan="3">{{ $empleado->nombre_completo }}</td>
							<td style="padding:2px" class="font-bold">Nº de Cédula</td>
							<td style="padding:2px" >{{ $empleado->cedula_empleado }}</td>
						</tr>
						<tr>
							<td style="padding:2px" class="font-bold">Cargo/Ocupación actual</td>
							<td style="padding:2px" colspan="2" >{{$evaluacion->cargo_emp->nombre}}</td>
							<td class="font-bold" style="width:15%; padding:2px">Coordinación/Unidad</td>
							<td style="padding:2px" colspan="2" rowspan="2">{{ $evaluacion->dep_emp->nombre }}</td>
						</tr>
						<tr>
							<td style="padding:2px" colspan="3" class="font-bold">Fecha de ingreso a la empresa</td>
							<td style="padding:2px" >{{ $empleado->fecha_ingreso->format('d-m-Y') }}</td>
						</tr>
						<tr>
							<td style="padding:2px" colspan="2" class="font-bold">Periodo Evaluado</td>
							<td style="padding:2px" colspan="2"><span class="font-bold">Desde:</span> {{ $evaluacion->periodo_desde->format('d-m-Y') }}</td>
							<td style="padding:2px" colspan="2"><span class="font-bold">Hasta:</span> {{ $evaluacion->periodo_hasta->format('d-m-Y') }}</td>
						</tr>

						<tr>
							<td style="padding:2px" colspan="2" class="font-bold">Motivo de evaluación</td>
							<td style="padding:2px">{{ ucfirst($evaluacion->motivo) }}</td>
							<td style="padding:2px" colspan="2" class="font-bold">Tipo de evaluación</td>
							<td style="padding:2px">{{ ucfirst($evaluacion->tipo) }}</td>
						</tr>
						<tr>
							<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Aspectos a evaluar</td>
						</tr>
                        @php
                            $cant_items = $evaluacion->item_evaluado()->count();
                            $cant_items1 = $evaluacion->item_evaluado()->count();
                            $prom = 0;
                        @endphp
                        @foreach ($factores as $factor)
                            <tr>
                                <td colspan="6" class="font-bold text-uppercase bg-info text-center">{{ $factor->nombre }}</td>
                            </tr>
                            @php
                                $can = 0;
                            @endphp
                            @foreach ($evaluacion->item_evaluado as $item)
                                @if ($factor->id_factor == $item->factor->id_factor)
                                    @if ($can == 0)
                                        <tr>
                                    @endif
                                        <td style="padding:2px" class="font-bold">{{ $item->nombre }}</td>
                                        <td style="padding:2px">{{ $item->pivot->puntaje }}</td>
                                        @php
                                            $can++;
                                            $cant_items--;
                                            $prom = $prom + $item->pivot->puntaje;
                                        @endphp
                                        @if ($cant_items == 0)
                                            @if ($can == 2)
                                                <td style="padding:2px" colspan="2"></td>
                                                </tr>
                                                @php
                                                    $can = 0;
                                                @endphp
                                            @elseif ($can == 1)
                                                <td style="padding:2px" colspan="4"></td>
                                                </tr>
                                                @php
                                                    $can = 0;
                                                @endphp
                                            @endif
                                        @endif
                                @else
                                    @if ($can == 2)
                                        <td style="padding:2px" colspan="2"></td>
                                        </tr>
                                        @php
                                            $can = 0;
                                        @endphp
                                    @elseif ($can == 1)
                                        <td style="padding:2px" colspan="4"></td>
                                        </tr>
                                        @php
                                            $can = 0;
                                        @endphp
                                    @endif
                                @endif
                                @if ($can == 3)
                                    </tr>
                                    @php
                                        $can = 0;
                                        // if ($cant_items == 4)
                                        // $var = true;
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
						<tr>
							<td colspan="2">Descripción, Motivo y Situación</td>
							<td colspan="4"><p>{{ $evaluacion->descripcion }}</p></td>
						</tr>
						<tr>
							<td colspan="2">Recomendación para asignación</td>
							<td colspan="4"><p>{{ $evaluacion->recomendacion }}</p></td>
						</tr>
						<tr>
							<td colspan="2">Comentario general del evaluador</td>
							<td colspan="4"><p>{{ $evaluacion->comentario }}</p></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
        <hr>
		<div class="m-t-lg">
			<div class="table-responsive">
				<table class="table table-condensed borde-tabla" style="margin-bottom:0">
					<tr>
						<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Datos del evaluador</td>
					</tr>
                    @if (isset($evaluador))
                        <tr>
                            <td style="width:25%" class="font-bold">Apellidos y Nombres</td>
                            <td colspan="3">{{ $evaluador->nombre_completo }}</td>
                            <td style="width:15%">Nº de cédula</td>
                            <td style="width:15%">{{ $evaluador->cedula_empleado }}</td>
                        </tr>
                        <tr>
                            <td  class="font-bold">Cargo:</td>
                            <td colspan="5">{{ $evaluador->cargo->nombre }}</td>
                        </tr>
                    @else
                        <tr>
                            <td  class="font-bold">Apellidos y Nombres</td>
                            <td colspan="3">{{ $th->nombre_completo }}</td>
                            <td >Nº de cédula</td>
                            <td >{{ $th->cedula_empleado }}</td>
                        </tr>
                        <tr>
                            <td  class="font-bold">Cargo:</td>
                            <td colspan="5">{{ $th->cargo->nombre }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="vertical-align: middle">Firma</td>
                        <td colspan="3"></td>
                        <td style="vertical-align: middle">Sello</td>
                        <td style="height:60px;"></td>
                    </tr>
                    @if (isset($responsable))
                        <tr>
                            <td colspan="6" class="font-bold text-uppercase bg-muted text-center">Datos de verificación por el superior inmediato al evaluador</td>
                        </tr>
                        <tr>
                            <td  class="font-bold">Apellidos y Nombres</td>
                            <td colspan="3">{{ $responsable->nombre_completo }}</td>
                            <td >Nº de cédula</td>
                            <td >{{ $responsable->cedula_empleado }}</td>
                        </tr>
                        <tr>
                            <td  class="font-bold">Cargo:</td>
                            <td colspan="5">{{ $responsable->cargo->nombre }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle">Firma</td>
                            <td colspan="3"></td>
                            <td style="vertical-align: middle">Sello</td>
                            <td style="height:60px;"></td>
                        </tr>
                    @endif
                    <tr>
						<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Datos de verificación por talento humano</td>
					</tr>
                    <tr>
                        <td  class="font-bold">Apellidos y Nombres</td>
                        <td colspan="3">{{ $th->nombre_completo }}</td>
                        <td >Nº de cédula</td>
                        <td >{{ $th->cedula_empleado }}</td>
                    </tr>
                    <tr>
                        <td  class="font-bold">Cargo:</td>
                        <td colspan="5">{{ $th->cargo->nombre }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle">Firma</td>
                        <td colspan="3"></td>
                        <td style="vertical-align: middle">Sello</td>
                        <td style="height:60px;"></td>
                    </tr>
                    <tr>
						<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Datos de verificación por gerencia</td>
					</tr>
                    <tr>
                        <td  class="font-bold">Apellidos y Nombres</td>
                        <td colspan="3">{{ $gerente->nombre_completo }}</td>
                        <td >Nº de cédula</td>
                        <td >{{ $gerente->cedula_empleado }}</td>
                    </tr>
                    <tr>
                        <td  class="font-bold">Cargo:</td>
                        <td colspan="5">{{ $gerente->cargo->nombre }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle">Firma</td>
                        <td colspan="3"></td>
                        <td style="vertical-align: middle">Sello</td>
                        <td style="height:60px;"></td>
                    </tr>
                    <tr>
						<td colspan="6" class="font-bold text-uppercase bg-muted text-center">Notificación al evaluado</td>
					</tr>
                    <tr>
                        <td class="font-bold">Promedio de calificación</td>
                        <td>{{ round($prom = $prom/$cant_items1,1) }}</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td class="font-bold">Toma de conocimiento</td>
                        <td>Si </td>
                        <td>No </td>
                        <td class="font-bold text-right">Conforme</td>
                        <td>Si </td>
                        <td>No </td>
                    </tr>
                    <tr class="td-no-border">
                        <td class="td-no-border-l">Rango de evaluación</td>
                        <td class="td-no-border">1. Deficiente</td>
                        <td class="td-no-border">2. Regular</td>
                        <td class="td-no-border">3. Bueno</td>
                        <td class="td-no-border">4. Muy bueno</td>
                        <td class="td-no-border-r">5. Excelente</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right td-no-border-l">Fecha entrevista</td>
                        <td class="td-no-border-r" style="border-bottom: 1px solid black !important"></td>
                    </tr>
				</table>
                <table class="table borde-tabla table2">
                    <tr>
                        <td colspan="5" style="border-top:0; border-bottom:0"></td>
                    </tr>
                    <tr>
                        <td style="width:35%;border-top: 0 !important;border-bottom: 0 !important;border-right: 0;">Firma del evaluado</td>
                        <td style=" border-left: 0; border-right: 0; border-bottom: 0;"></td>
                        <td style="width:1%;/* border-top: 0 !important; */border-left: 0;border-bottom: 0;border-right: 0;"></td>
                        <td style="border-bottom: 0;border-left: 0;border-right: 0;"></td>
                        <td style="width:35%;border-top: 0 !important;border-left: 0; border-bottom:0"></td>
                    </tr>
                    <tr>
                        <td style="width:35%; border-top: 0 !important; border-bottom:0">Huella dactilar</td>
                        <td style="height: 60px"></td>
                        <td style="width:1%; border-top: 0 !important;border-bottom:0"></td>
                        <td></td>
                        <td style="width:35%; border-top: 0 !important;border-bottom:0"></td>
                    </tr>
                    <tr>
                        <td style="width:35%; border-top: 0 !important; border-right:0"></td>
                        <td class="text-center" style="border-left:0; border-right:0; border-left:0">Izq</td>
                        <td style="width:1%; border-top: 0 !important; border-right:0; border-left:0"></td>
                        <td class="text-center" style="border-left:0; border-right:0; border-left:0 "> Der</td>
                        <td style="width:35%; border-top: 0 !important; border-left:0"></td>
                    </tr>
                </table>
			</div>
		</div>
                    {{-- <div class="ibox-content p-xxs">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h5>From:</h5>
                                    <address>
                                        <strong>Inspinia, Inc.</strong><br>
                                        106 Jorg Avenu, 600/10<br>
                                        Chicago, VT 32456<br>
                                        <abbr title="Phone">P:</abbr> (123) 601-4590
                                    </address>
                                </div>

                                <div class="col-xs-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy">INV-000567F7-00</h4>
                                    <span>To:</span>
                                    <address>
                                        <strong>Corporate, Inc.</strong><br>
                                        112 Street Avenu, 1080<br>
                                        Miami, CT 445611<br>
                                        <abbr title="Phone">P:</abbr> (120) 9000-4321
                                    </address>
                                    <p>
                                        <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br/>
                                        <span><strong>Due Date:</strong> March 24, 2014</span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Item List</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>Admin Theme with psd project layouts</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>1</td>
                                        <td>$26.00</td>
                                        <td>$5.98</td>
                                        <td>$31,98</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Wodpress Them customization</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                Eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </small></td>
                                        <td>2</td>
                                        <td>$80.00</td>
                                        <td>$36.80</td>
                                        <td>$196.80</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Angular JS & Node JS Application</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>3</td>
                                        <td>$420.00</td>
                                        <td>$193.20</td>
                                        <td>$1033.20</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$1026.00</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td>$235.98</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td>$1261.98</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="well m-t"><strong>Comments</strong>
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                            </div> --}}
    </div>
</div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>

</body>

</html>
