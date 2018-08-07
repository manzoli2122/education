@extends('layout.master')
  
@section('content')  
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Usuário não autenticado </h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/">Principal</a></li> 
					</ol>
				</div> 
			</div> 
		</div> 
	</div>

	<div class="content">
		<div class="container-fluid">
			<h2> Erro 401 - {{ $exception->getMessage() }} </h2> 
			<h2> O acesso deste sistema somente poderar ser feito através do sistema único de autenticação do <a href="{{env('APP_URL_LOGIN_BAON')}}">BAON</a> </h2> 
			 
		</div> 
	</div>  
@endsection
 