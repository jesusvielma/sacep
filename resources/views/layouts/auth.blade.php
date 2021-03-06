<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>

	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    @yield('css')

</head>

<body class="gray-bg ">
    <div class="">
        <img src="{{ asset('img/sacep.jpg') }}" alt="" class="img-responsive stm-sacep2">
    </div>
     @yield('content')

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
