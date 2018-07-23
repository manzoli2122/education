@extends('layout.master')

@section('content-header')
    Perfil
@endsection


@section('header') 
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="perfil#/" class="nav-link">Perfil</a>
	</li> 

	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="perfil#/create" class="nav-link">Cadastrar Perfil</a>
	</li>
@endsection


@section('content') 
	<div id="perfil">				
        <router-view :url="{{ json_encode( route('perfil.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/perfil.js') }}" type="text/javascript"></script>
@endpush