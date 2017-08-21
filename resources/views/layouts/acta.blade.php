<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }} | Acta de {{ trans('acta.tipo.'.$acta->tipo) }}</title>

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<style>
        @page {margin: 2cm 2.5cm 2.5cm 2cm}
        html, body {
            background: #FFF;
        }
		body {
			/*margin: 1cm 1cm 1cm 1cm;*/
			color: black;
            padding: 0
		}
        hr {
            page-break-after: always;
            border: 0;
        }
		#header{
			 position: fixed;
			 /*left: 0.5cm;
			 right: 1cm;*/
             top: -10px;
		}
        #footer {
            bottom: : 0px;
            position: fixed;
            /*left: 0.5cm;
            right: 1cm;*/
        }
        /*.body-acta {
            margin-left: -0.5cm
        }*/
		.borde-tabla > tbody > tr > td  {
			border: 1px solid black;
		}
		table {
			font-size: 10px
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
        p {
            text-align: justify;
        }
	</style>

</head>

<body class="">
    <div id="header">
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ asset('img/cabecera_acta.png') }}" alt="" class="img-responsive">
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ asset('img/pie_acta.jpg') }}" alt="" class="img-responsive">
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
