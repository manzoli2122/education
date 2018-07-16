<!DOCTYPE html> 
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1, maximum-scale=2' name='viewport'>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="api-token" content="{{session('token_api')}}">
	<!--meta http-equiv="refresh" content="120"--> 
	<meta name="theme-color" content="#00a65a">
	<title> SGPM-EDU </title>
	<!--  Bootstrap -->
	<link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/> 
	<!-- font-awesome  ionicons --> 
	<link href="{{ mix('css/fonts.css') }}" rel="stylesheet" type="text/css"/>
	<!-- template --> 
	<link href="css/adminlte.css" rel="stylesheet" type="text/css"/> 
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> 
	@stack('styles')

</head>
<body class="hold-transition sidebar-mini">
	
	<div class="wrapper">

		@include('layout.header')

		@include('layout.sidebar')
 
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper"> 
			@yield('content') 
		</div> 

		<!-- Main Footer -->
		<footer class="main-footer"> 
			<div class="float-right d-none d-sm-inline">
				Versão 0.0.1
			</div> 
			<strong>Copyright &copy; 2018 <a href="#">SGPM-EDU</a>.</strong> Todos Direitos Reservados.
		</footer>
	</div>
 

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery  Bootstrap  -->
	<script src="{{ mix('js/vendor.js') }}" type="text/javascript"></script>

	<!-- AdminLTE App  -->
	<script src="js/adminlte.js" type="text/javascript"></script>
 
	<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

  

	@stack('script')



</body>
</html>
