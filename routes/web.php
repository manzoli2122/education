<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
*/
 

Route::get('/carrega', 'Auth\LoginController@carregaBanco');//->middleware('auth:api');

Route::get('/', function () {    return view('welcome');})->name('inicio');
Route::get('/home', function () {    return view('welcome');})->middleware('auth')->name('inicio');
 

 
// Rotas para autenticação
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 
Route::get('login/token', 'Auth\LoginController@authenticate');//->middleware('auth:api');



Route::post('profile/ativacao/{mailable_id}',      'ProfileController@AtivarNotificacaoEmail') ;  
Route::delete('profile/desativacao/{mailable_id}', 'ProfileController@DesativarNotificacaoEmail') ; 
Route::post('profile/mailable/datatable',  'ProfileController@getNotificacaoDatatable') ;


Route::get('profile/notificacoes',  'ProfileController@notifications') ; 
Route::post('profile/limpar/notificacoes',  'ProfileController@limparNotifications') ; 


 
Route::get('profile',                         'ProfileController@profile')->name('profile'); 






