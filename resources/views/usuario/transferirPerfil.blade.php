@extends('layout.master')
   
@section('content') 
	<div id="tranferirPerfil">				
        <router-view :url="{{ json_encode( route('tranferir.perfil.index')  ) }}"  :url_usuario="{{ json_encode( route('usuario.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/tranferirPerfil.js') }}" type="text/javascript"></script>
@endpush