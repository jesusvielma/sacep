<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SACEP | 404 </title>

	<!-- CSS principal -->
    <link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>{{ $exception->getStatusCode() }}</h1>
        <h3 class="font-bold">Lo sentimos, no hay coincidencias</h3>

        <div class="error-desc">
            No hemos podido encontrar la información solicitada, le recomendamos que regrese a la pagina anterior y vuelva a intentarlo.
            <br>
			<a href="{{ url()->previous() }}" class="btn btn-success"> <i class="fa fa-reply"></i> Atras</a> <a href="{{ route('pagina_inicio') }}" class="btn btn-primary"><i class="fa fa-home"></i>Inicio</a>
        </div>
    </div>

    <!-- Mainly scripts -->
	<script src="{{URL::asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>

</body>

</html>
