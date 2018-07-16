@extends('layout.master')

@section('content-header')
    Permissão
@endsection


@section('header') 
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="permissao#/" class="nav-link">Permissão</a>
	</li> 

	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="permissao#/create" class="nav-link">Cadastrar Permissão</a>
	</li>
@endsection


@section('content') 
	<div id="permissao">				
        <router-view :url="{{ json_encode( route('permissao.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/permissao.js') }}" type="text/javascript"></script>
@endpush