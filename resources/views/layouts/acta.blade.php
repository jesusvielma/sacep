<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{ env('APP_NAME') }} |

        @if (isset($acta))
            Acta de {{ trans('acta.tipo.'.$acta->tipo) }}
        @elseif (isset($llamado))
            Llamado de atención de {{ $sancionado->nombre_completo }}
        @endif
    </title>

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<style>
        @page {margin: 1.5cm 2cm 1.5cm 1.5cm}
        html, body {
            background: #FFF;
        }
		body {
			/*margin: 1cm 1cm 1cm 1cm;*/
			color: black;
            padding: 0;
            font-size: 10.5pt;
            font-family: sans-serif;
            text-align: justify;
		}
        hr {
            page-break-after: always;
            border: 0;
        }
		#header{
			position: fixed;
			left: 0;
			right: 0;
            top: -30;
		}
        #footer {
            bottom: 30;
            position: fixed;
            left: 0;
            right: 0;
        }
        .body-acta {
            margin-top: 1.2cm;
            margin-left: 3.85cm;
            margin-bottom: 1.5cm;
        }
		.borde-tabla > tbody > tr > td  {
			border: 1px solid black;
		}
		table, tr, td {
			border: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
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
        blockquote{
            border: 0;
            text-align: justify;
            font-size: 12px;
            font-style: italic;
        }
        .other-page {
            page-break-before: always;
            margin-top: 1.5cm;
            margin-left: 3.85cm;
            orphans: 10;
            widows: 1;
        }
	</style>

</head>

<body class="">
    <div id="header">
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ asset('img/membrete-superior.png') }}" alt="" class="img-responsive" style="height:80px" >
                {{-- <img src="{{ asset('img/membrete-superior.png') }}" alt="" class="img-responsive"> --}}
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ asset('img/membrete-inferior.png') }}" alt="" class="img-responsive">
            </div>
        </div>
    </div>
    @yield('content')
</div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>

</body>

</html>
