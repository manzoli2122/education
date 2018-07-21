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



//==========================================================================================================================
//                              SEGURANCA USUARIO
//==========================================================================================================================
Route::post('usuario/{userId}/adicionar/perfil', 'Security\UsuarioController@adicionarPerfilAoUsuario') ;
Route::post('usuario/{userId}/delete/perfil/{perfilId}', 'Security\UsuarioController@excluirPerfilDoUsuario') ;
Route::post('usuario/{userId}/perfil/datatable', 'Security\UsuarioController@BuscarPerfilDataTable') ; 
Route::post('usuario/{userId}/perfil/log/datatable',  'Security\UsuarioController@BuscarPerfilDataTableLog'); 
Route::post('usuario/datatable',                 'Security\UsuarioController@getDatatable') ;  
Route::get('usuario/{userId}/perfil/adicionar', 'Security\UsuarioController@BuscarPerfisParaAdicionar') ;  
Route::resource('usuario',                          'Security\UsuarioController')->only(['index', 'show']);


 

//========================================================================================================================
//                              SEGURANCA PERFIL
//========================================================================================================================
Route::post('perfil/{perfilId}/adicionar/permissao', 'Security\PerfilController@adicionarPermissaoAoPerfil') ; 
Route::post('perfil/{perfilId}/delete/permissao/{permissaoId}', 'Security\PerfilController@excluirPermissaoDoPerfil') ;
Route::get('perfil/{perfilId}/permissao/adicionar', 'Security\PerfilController@BuscarPermissoesParaAdicionar') ; 
Route::post('perfil/{perfilId}/permissao/datatable', 'Security\PerfilController@BuscarPermissaoDataTable') ;

Route::post('perfil/datatable', 'Security\PerfilController@getDatatable') ;  
Route::resource('perfil', 'Security\PerfilController')->except(['create', 'edit']); 


















Route::post('disciplina/getDatatable', 'DisciplinaController@getDatatable')->name('disciplina.getDatatable');
 
Route::resource('disciplina', 'DisciplinaController')->except(['create', 'edit']); 






Route::post('permissao/getDatatable', 'Security\PermissaoController@getDatatable')->name('permissao.getDatatable');  
Route::resource('permissao', 'Security\PermissaoController')->except(['create', 'edit']); 







    //Route::any('perfil/{id}/usuario/pesquisar',       'Security\PerfilController@pesquisarUsuarios')->name('perfil.usuario.pesquisar');
   // Route::get('perfil/{id}/usuario/{userId}/delete', 'Security\PerfilController@deleteUser')->name('perfil.usuario.delete');
    //Route::post('perfil/{id}/usuario/cadastrar',      'Security\PerfilController@addUsuarios')->name('perfil.usuario.add');
   // Route::get('perfil/{id}/usuario/cadastrar',       'Security\PerfilController@usuariosParaAdd')->name('perfil.usuario.cadastrar');
  //  Route::get('perfil/{id}/usuario',                 'Security\PerfilController@usuarios')->name('perfil.usuario');



 
    
    
    

     

 

 
        
         
       
