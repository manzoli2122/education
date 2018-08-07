@extends('layout.master')
 
@section('content') 
	<div id="profile">				
        <router-view :url="{{ json_encode( route('profile')  ) }}" :user="{{$user}}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/profile.js') }}" type="text/javascript"></script>
@endpush