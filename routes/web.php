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

Route::get('/', function () {
    return view('welcome');
})->name('inicio');





Route::post('disciplina/getDatatable', 'DisciplinaController@getDatatable')->name('disciplina.getDatatable');
 
Route::resource('disciplina', 'DisciplinaController')->except(['create', 'edit']); 



Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');





Route::post('permissao/getDatatable', 'Security\PermissaoController@getDatatable')->name('permissao.getDatatable');  
Route::resource('permissao', 'Security\PermissaoController')->except(['create', 'edit']); 











    Route::any('perfil/{id}/usuario/pesquisar',       'Security\PerfilController@pesquisarUsuarios')->name('perfil.usuario.pesquisar');
    Route::get('perfil/{id}/usuario/{userId}/delete', 'Security\PerfilController@deleteUser')->name('perfil.usuario.delete');
    Route::post('perfil/{id}/usuario/cadastrar',      'Security\PerfilController@addUsuarios')->name('perfil.usuario.add');
    Route::get('perfil/{id}/usuario/cadastrar',       'Security\PerfilController@usuariosParaAdd')->name('perfil.usuario.cadastrar');
    Route::get('perfil/{id}/usuario',                 'Security\PerfilController@usuarios')->name('perfil.usuario');



    Route::any('perfil/{id}/permissao/pesquisar',            'Security\PerfilController@pesquisarPermissoes')->name('perfil.permissao.pesquisar');
    Route::get('perfil/{id}/permissao/{permissaoId}/delete', 'Security\PerfilController@deletePermissao')->name('perfil.permissao.delete');
    Route::post('perfil/{id}/permissao/cadastrar',           'Security\PerfilController@addPermissoes')->name('perfil.permissao.add');
    Route::get('perfil/{id}/permissao/cadastrar',            'Security\PerfilController@permissoesParaAdd')->name('perfil.permissao.cadastrar');
    Route::get('perfil/{id}/permissao',                      'Security\PerfilController@permissoes')->name('perfil.permissao');

     

    Route::post('perfil/getDatatable', 'Security\PerfilController@getDatatable')->name('perfil.getDatatable');  
    Route::resource('perfil', 'Security\PerfilController')->except(['create', 'edit']); 










        Route::get('usuario/{id}/perfil/{perfilId}/delete', 'Security\UsuarioController@deletePerfil')->name('usuario.perfil.delete');
        Route::post('usuario/{id}/perfil/cadastrar',        'Security\UsuarioController@addPerfil')->name('usuario.perfil.add');
        Route::get('usuario/{id}/perfil/cadastrar',         'Security\UsuarioController@perfisParaAdd')->name('usuario.perfil.cadastrar'); 
        Route::get('usuario/{id}/perfil',                   'Security\UsuarioController@perfis')->name('usuario.perfil'); 
        Route::post('usuario/getDatatable',                 'Security\UsuarioController@getDatatable')->name('usuario.getDatatable');        
        Route::resource('usuario',                          'Security\UsuarioController')->only(['index', 'show']);
