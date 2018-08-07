<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 

Route::get('/', function () {    return view('welcome');})->name('inicio');
Route::get('/home', function () {    return view('welcome');})->middleware('auth')->name('inicio');
 

 
// Rotas para autenticação
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 
Route::get('login/token', 'Auth\LoginController@authenticate');//->middleware('auth:api');




Route::post('profile/ativacao/{mailable_id}',      'ProfileController@Ativar') ;  
Route::delete('profile/desativacao/{mailable_id}', 'ProfileController@Desativar') ; 


Route::get('profile/notificacoes',  'ProfileController@notifications') ; 
Route::post('profile/limpar/notificacoes',  'ProfileController@limparNotifications') ; 


Route::post('profile/notificacao/datatable',  'ProfileController@getNotificacaoDatatable') ; 
Route::get('profile',                         'ProfileController@profile')->name('profile'); 
