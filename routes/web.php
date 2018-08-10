<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
*/
 

Route::get('/', function () {    return view('welcome');})->name('inicio');
//Route::get('/home', function () {    return view('welcome');})->middleware('auth')->name('inicio');
 

 
// Rotas para autenticação
//Route::post('login', 'Auth\LoginController@login');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 
Route::get('login/token', 'Auth\LoginController@authenticate');//->middleware('auth:api');





// PROFILE
Route::post('profile/ativacao/{mailable_id}',      'ProfileController@AtivarNotificacaoEmail') ;  
Route::delete('profile/desativacao/{mailable_id}', 'ProfileController@DesativarNotificacaoEmail') ; 
Route::post('profile/mailable/datatable',  'ProfileController@getNotificacaoDatatable') ;

Route::get('profile/notificacoes',  'ProfileController@notifications') ; 
Route::post('profile/limpar/notificacoes',  'ProfileController@limparNotifications') ; 

Route::get('profile',   'ProfileController@profile')->name('profile'); 





// ROTAS TEMPORARIAS A SEREM APAGADAS

Route::get('/admin/carrega/rh', 'TemporarioController@carregaBanco');//->middleware('auth:api');
Route::get('/admin/carrega/rh/{cpf}', 'TemporarioController@carregaBancoCpf');//->middleware('auth:api');

//Route::post('login', 'Auth\AuthController@login');
Route::get('/admin/login/{cpf?}', 'Auth\AuthController@login');

