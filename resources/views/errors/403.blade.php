<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | 404 Error</title>

	<!-- CSS principal -->
    <link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>{{ $exception->getStatusCode() }}</h1>
        <h3 class="font-bold">No puede realizar la acción solicitada</h3>

        <div class="error-desc">
            Lo sentimos, pero la acción solicitada no puede ser procesada ya que no cuenta con las permisos necesarios para la misma, le invitamos a corroborar la solicitud.
			<a href="{{ route('pagina_inicio') }}" class="btn btn-block btn-success">Inicio</a>
        </div>
    </div>

    <!-- Mainly scripts -->
	<script src="{{URL::asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>

</body>

</html>
