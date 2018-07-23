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

Route::get('/home', function () {    return view('welcome');})->name('home')->middleware('auth');

Route::get('/teste', function () {    return view('welcome');})->name('teste')->middleware('permissao:disciplina-cadastrar');
 
Auth::routes();
   

Route::post('disciplina/getDatatable', 'DisciplinaController@getDatatable')->name('disciplina.getDatatable');

Route::resource('disciplina', 'DisciplinaController')->except(['create', 'edit']); 





 