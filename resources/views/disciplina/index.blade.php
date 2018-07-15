@extends('layout.master')

@section('content-header')
    Disciplina
@endsection


@section('header') 
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="disciplina#/create" class="nav-link">Cadastrar Disciplina</a>
	</li>
	
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="disciplina#/" class="nav-link">Listar Disciplina</a>
	</li>
	 
@endsection


@section('content') 
	<div id="disciplina">				
        <router-view :url="{{ json_encode( route('disciplina.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/disciplina.js') }}" type="text/javascript"></script>
@endpush