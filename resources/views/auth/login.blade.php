@extends('layouts.auth')
@section('title')
    Inicio de sesión
@endsection


@section('content')
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Bienvenido a {{ env('APP_NAME') }}</h2>

                <p>
                    Bienvenido al Sistema Automatizado para el Control y Evaluación del Personal de Mukumbarí Sitema Teléferico de Mérida.
                </p>

            </div>
            <div class="col-md-6">
                @if ($errors)
                    <div class="alert alert-danger">
                        {{ dd($errors) }}
                    </div>
                @endif
                <div class="ibox-content">
                    <form class="m-t" role="form" action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="correo" class="form-control" placeholder="Correo" required="" value="{{ old('correo') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('correo') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" placeholder="Clave" required="">
                            @if ($errors->has('clave'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clave') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Entrar</button>

                        {{-- <a href="login_two_columns.html#">
                            <small>Forgot password?</small>
                        </a> --}}

                        {{-- <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> --}}
                    </form>
                    <p class="m-t">
                        <small> {{ env('APP_NAME') }} - 2017</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        {{-- <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2014-2015</small>
            </div>
        </div> --}}
    </div>
@endsection
