@extends('layout.master')
  
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="usuario#/create" class="nav-link">Cadastrar Usuário</a>
	</li>
@endsection


@section('content') 
	<div id="usuario">				
        <router-view :url="{{ json_encode( route('usuario.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/usuario.js') }}" type="text/javascript"></script>
@endpush