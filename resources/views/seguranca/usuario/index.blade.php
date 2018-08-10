@extends('layout.master')
   
@section('content') 
	<div id="usuario">				
        <router-view :url="{{ json_encode( route('usuario.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/usuario.js') }}" type="text/javascript"></script>
@endpush