@extends('layout.master')
 
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="perfil#/create" class="nav-link">
			<i class="fa fa-plus"></i> Cadastrar Perfil
		</a>
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