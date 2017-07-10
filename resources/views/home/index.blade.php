@extends('layouts.main')
@section('title')
	Inicio
@endsection
@section('css')
	<!-- Toastr style -->
    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endsection

@section('js')
	<!-- Toastr -->
    <script src="{{URL::asset('js/plugins/toastr/toastr.min.js')}}"></script>
	@if (session('login'))
		<script>
			$(document).ready(function () {
				setTimeout(function() {
	                toastr.options = {
	                    closeButton: true,
	                    progressBar: true,
	                    showMethod: 'slideDown',
	                    timeOut: 4000
	                };
	                toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');
	            }, 1300);
			})
		</script>
	@endif

@endsection

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
			<h2>This is main title</h2>
			<ol class="breadcrumb">
				<li>
					<a href="index.html">This is</a>
				</li>
				<li class="active">
					<strong>Breadcrumb</strong>
				</li>
			</ol>
		</div>
		<div class="col-sm-8">
			<div class="title-action">
				<a href="empty_page.html" class="btn btn-primary">This is action area</a>
			</div>
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
