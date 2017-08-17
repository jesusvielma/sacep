<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>

	<!-- CSS principal -->
    <link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- CSS extra -->
	@yield('css')

    <link href="{{ URL::asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">



</head>

<body class="fixed-sidebar ">

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ URL::asset('img/profile_small.jpg')}}" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        @if (isset(Auth::user()->empleado->nombre_completo))
                                            {{ strlen(Auth::user()->nombre) < strlen(Auth::user()->empleado->nombre_completo) ? Auth::user()->nombre : Auth::user()->empleado->nombre_completo }}
                                        @else
                                            {{ Auth::user()->nombre }}
                                        @endif
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">{{ isset(Auth::user()->empleado->cargo->nombre) ? Auth::user()->empleado->cargo->nombre : 'Admin' }} <b class="caret"></b></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="{{ route('perfil') }}">Perfil</a></li>
                            {{--<li><a href="#">Contacts</a></li>
                            <li><a href="#">Mailbox</a></li> --}}
                            <li class="divider"></li>
                            <li><a href="{{ route('salir') }}">Cerrar sesión</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                {{-- <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
                </li> --}}
                @can('config')
                    <li class="{{ $current_route_name == 'departamento.index' || $current_route_name == 'departamento.create' || $current_route_name == 'departamento.edit' || $current_route_name == 'cargo.edit' || $current_route_name == 'cargos' || $current_route_name == 'cargo_nuevo' || $current_route_name == 'factores' ? 'active' : NULL }}">
                        <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Configuraciones</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{ $current_route_name == 'departamento.index' || $current_route_name == 'departamento.create' || $current_route_name == 'departamento.edit' ? 'active' : NULL }}">
                                <a href="#">Coordinación/Unuidad <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{ route('departamento.create') }}">Nuevo</a></li>
                                    <li><a href="{{ route('departamento.index') }}">Listado</a></li>
                                </ul>
                            </li>
                            <li class="{{ $current_route_name == 'cargos' || $current_route_name == 'cargo_nuevo' || $current_route_name == 'cargo.edit' ? 'active' : NULL }}">
                                <a href="#">Cargos <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{ route('cargos') }}">Todos</a></li>
                                </ul>
                            </li>
                            <li class="{{ $current_route_name == 'factores' || $current_route_name == 'factor_nuevo' || $current_route_name == 'editar_factor' ? 'active' : NULL }}">
                                <a href="#">Evaluación <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{ route('factores') }}">Factores</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ $current_route_name == 'empleados' || $current_route_name == 'empleado_nuevo'? 'active' : NULL }}">
                        <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">Empleados </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('empleados') }}">Todos</a></li>
                            <li><a href="{{ route('empleado_nuevo') }}">Nuevo</a></li>
                        </ul>
                    </li>
                @endcan
                @can('admin')
                    <li class="{{ $current_route_name == 'usuarios' || $current_route_name == 'crear_usuario' || $current_route_name == 'editar_usuario'? 'active' : NULL }}">
                        <a href="#"><i class="fa fa-user-o"></i> <span class="nav-label">Usuarios</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('usuarios') }}">Todos</a></li>
                            <li><a href="{{ route('crear_usuario') }}">Nuevo</a></li>
                        </ul>
                    </li>
                    <li class="{{ $current_route_name == 'operaciones_masivas' ? 'active' : NULL }}">
                        <a href="{{ route('operaciones_masivas') }}"><i class="fa fa-cubes"></i> <span class="nav-label">Opereaciones masivas</span></a>
                    </li>
                    {{-- <li >
                        <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Base de datos</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('usuarios') }}">Todos</a></li>
                            <li><a href="{{ route('crear_usuario') }}">Nuevo</a></li>
                        </ul>
                    </li> --}}
                @endcan
                @can('ver_ev')
                    <li class="{{ $current_route_name == 'index_evaluar' || $current_route_name == 'procesar_index' || $current_route_name == 'evaluar' || $current_route_name == 'editar_evaluacion' || $current_route_name == 'evaluaciones' ? 'active' : NULL }}">
                        <a href="#"><i class="fa fa-pie-chart"></i> <span class="nav-label">Evaluaciones</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('index_evaluar') }}">Evaluar</a></li>
                            @can('procesar')
                            <li><a href="{{ route('procesar_index') }}">Procesar</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('material',sacep\Departamento::class)
                <li class="{{ $current_route_name == 'materiales' || $current_route_name == 'crear_material' || $current_route_name == 'editar_material' || $current_route_name == 'mostrar_material'? 'active' : NULL }}">
                    <a href="#"><i class="fa fa-puzzle-piece"></i> <span class="nav-label">Materiales</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('materiales') }}">Todos</a></li>
                        <li><a href="{{ route('crear_material',['id'=>Auth::user()->empleado->id_departamento]) }}">Nuevo</a></li>
                    </ul>
                </li>
                @endcan
            </ul>
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Bienvenido a {{ env('APP_NAME') }}</span>
                </li>
                {{-- <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="#" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="#" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="#" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="#">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> --}}


                <li>
                    <a href="{{ route('salir') }}">
                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>

        </nav>
        </div>
		@yield('content')

        <div class="footer fixed">
            <div class="pull-right">
                Fecha <strong id="fechaPie"> </strong> Hora: <strong id="horaPie"> </strong>.
            </div>
            <div>
                <strong>Copyright</strong> Mukumbarí Sistema Teleférico de Mérida &copy; 2017
            </div>
        </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{URL::asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{URL::asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{URL::asset('js/inspinia.js')}}"></script>
    <script src="{{URL::asset('js/plugins/pace/pace.min.js')}}"></script>
    <script>
        $('.sidebar-collapse').slimScroll({
            height: '100%',
            railOpacity: 0.9
        });
    </script>
    <script src="{{URL::asset('js/plugins/fullcalendar/moment.min.js')}}"></script>
    <script src="{{URL::asset('js/plugins/fullcalendar/locale/es.js')}}"></script>
    <script>
        moment.locale('es');
        var fechaPie = moment().format('dd DD [de] MMM [de] YYYY');
        $('#fechaPie').text(fechaPie);
        clock();
        function clock() {
            var horaPie = moment().format('h:mm:ss a');
            $('#horaPie').text(horaPie);
            setTimeout("clock()", 1000);
        }
    </script>
	<!-- JS extras -->
	@yield('js')


</body>

</html>
