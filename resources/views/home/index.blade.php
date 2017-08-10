@extends('layouts.main')
@section('title')
	Inicio
@endsection
@section('css')
	<!-- Toastr style -->
    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
			<h2>Inicio</h2>
			<ol class="breadcrumb">
				<li class="active">
					<strong>Inicio</strong>
				</li>
			</ol>
		</div>
	</div>

	<div class="wrapper wrapper-content">
		<div class="middle-box text-center animated fadeInRightBig">
			<h3 class="font-bold">This is page content</h3>
			<div class="error-desc">
				You can create here any grid layout you want. And any variation layout you imagine:) Check out
				main dashboard and other site. It use many different layout.
				<br/><a href="index.html" class="btn btn-primary m-t">Dashboard</a>
			</div>
		</div>
	</div>
@endsection
