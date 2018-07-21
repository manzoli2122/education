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
 
Auth::routes();
 
Route::get('/home', 'HomeController@index')->name('home');



//==========================================================================================================================================
//                              SEGURANCA USUARIO
//==========================================================================================================================================
Route::post('usuario/{userId}/adicionar/perfil',    'Security\UsuarioController@adicionarPerfilAoUsuario')->name('usuario.adicionar.perfil');
Route::post('usuario/{userId}/delete/perfil/{perfilId}', 'Security\UsuarioController@excluirPerfilDoUsuario')->name('usuario.perfil.delete');
Route::post('usuario/{userId}/perfil/datatable',     'Security\UsuarioController@BuscarPerfilDataTable')->name('usuario.perfil.datatable'); 
Route::post('usuario/{userId}/perfil/log/datatable',  'Security\UsuarioController@BuscarPerfilDataTableLog')->name('usuario.perfil.datatable.log'); 
Route::post('usuario/datatable',                 'Security\UsuarioController@getDatatable')->name('usuario.getDatatable');  
Route::get('usuario/{userId}/perfil/adicionar',         'Security\UsuarioController@BuscarPerfisParaAdicionar')->name('usuario.perfil.adicionar');  
Route::resource('usuario',                          'Security\UsuarioController')->only(['index', 'show']);














Route::post('disciplina/getDatatable', 'DisciplinaController@getDatatable')->name('disciplina.getDatatable');
 
Route::resource('disciplina', 'DisciplinaController')->except(['create', 'edit']); 






Route::post('permissao/getDatatable', 'Security\PermissaoController@getDatatable')->name('permissao.getDatatable');  
Route::resource('permissao', 'Security\PermissaoController')->except(['create', 'edit']); 





//===========================================================================================================================================================
//                              SEGURANCA PERFIL
//===========================================================================================================================================================
    Route::post('perfil/{perfilId}/adicionar/permissao',           'Security\PerfilController@adicionarPermissaoAoPerfil')->name('perfil.adicionar.permissao');
    Route::get('perfil/{perfilId}/delete/permissao/{permissaoId}', 'Security\PerfilController@excluirPermissaoDoPerfil')->name('perfil.excluir.permissao');
    Route::post('perfil/{id}/permissao',                           'Security\PerfilController@getPermissaoDatatable')->name('perfil.permissao.datatable');
    Route::get('perfil/{id}/permissao/adicionar',                  'Security\PerfilController@permissoesParaAdicionar')->name('perfil.permissao.adicionar');






    Route::any('perfil/{id}/usuario/pesquisar',       'Security\PerfilController@pesquisarUsuarios')->name('perfil.usuario.pesquisar');
    Route::get('perfil/{id}/usuario/{userId}/delete', 'Security\PerfilController@deleteUser')->name('perfil.usuario.delete');
    Route::post('perfil/{id}/usuario/cadastrar',      'Security\PerfilController@addUsuarios')->name('perfil.usuario.add');
    Route::get('perfil/{id}/usuario/cadastrar',       'Security\PerfilController@usuariosParaAdd')->name('perfil.usuario.cadastrar');
    Route::get('perfil/{id}/usuario',                 'Security\PerfilController@usuarios')->name('perfil.usuario');



    Route::any('perfil/{id}/permissao/pesquisar',            'Security\PerfilController@pesquisarPermissoes')->name('perfil.permissao.pesquisar');
    Route::get('perfil/{id}/permissao/{permissaoId}/delete', 'Security\PerfilController@deletePermissao')->name('perfil.permissao.delete');
    Route::post('perfil/{id}/permissao/cadastrar',           'Security\PerfilController@addPermissoes')->name('perfil.permissao.add');
    
    

     

    Route::post('perfil/getDatatable', 'Security\PerfilController@getDatatable')->name('perfil.getDatatable');  
    Route::resource('perfil', 'Security\PerfilController')->except(['create', 'edit']); 



 

 
        
         
       
