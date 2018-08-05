<?php

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





//==============================================================================================================
//                              SEGURANCA USUARIO
//==============================================================================================================
Route::delete('usuario/{userId}/delete/perfil/{perfilId}',  'UsuarioController@excluirPerfilDoUsuario') ; 
Route::post('usuario/{userId}/adicionar/perfil',            'UsuarioController@adicionarPerfilAoUsuario') ;
Route::post('usuario/{userId}/delete/perfil/{perfilId}',    'UsuarioController@excluirPerfilDoUsuario') ; 
Route::post('usuario/{userId}/perfil/datatable',            'UsuarioController@BuscarPerfilDataTable') ; 
Route::post('usuario/{userId}/perfil/log/datatable',        'UsuarioController@BuscarPerfilDataTableLog');  
Route::get('usuario/{userId}/perfil/adicionar',             'UsuarioController@BuscarPerfisParaAdicionar') ; 
Route::get('usuario/{userId}/log/elasticsearch',            'UsuarioController@elasticsearch') ;  
Route::post('usuario/ativacao/{userId}',          	        'UsuarioController@Ativar') ;  
Route::delete('usuario/desativacao/{userId}',          	    'UsuarioController@Desativar') ;  

Route::post('usuario/datatable',                            'UsuarioController@getDatatable') ;
Route::resource('usuario',                                  'UsuarioController')->only(['index', 'show']);


 



//==============================================================================================================
//                              SEGURANCA PERFIL
//==============================================================================================================
Route::post('perfil/{perfilId}/adicionar/permissao',              'PerfilController@adicionarPermissaoAoPerfil') ; 
Route::post('perfil/{perfilId}/delete/permissao/{permissaoId}',   'PerfilController@excluirPermissaoDoPerfil') ;
Route::delete('perfil/{perfilId}/delete/permissao/{permissaoId}', 'PerfilController@excluirPermissaoDoPerfil') ;
Route::get('perfil/{perfilId}/permissao/adicionar',               'PerfilController@BuscarPermissoesParaAdicionar') ; 
Route::post('perfil/{perfilId}/permissao/datatable',              'PerfilController@BuscarPermissaoDataTable') ;
Route::post('perfil/{perfilId}/permissao/log/datatable',          'PerfilController@BuscarPermissaoDataTableLog'); 
Route::post('perfil/{perfilId}/usuarios/datatable',               'PerfilController@BuscarUsuariosDataTable'); 

Route::post('perfil/datatable',                                   'PerfilController@getDatatable') ;  
Route::resource('perfil',                                         'PerfilController')->except(['create', 'edit']); 



 



    //Route::any('perfil/{id}/usuario/pesquisar',       'Security\PerfilController@pesquisarUsuarios')->name('perfil.usuario.pesquisar');
   // Route::get('perfil/{id}/usuario/{userId}/delete', 'Security\PerfilController@deleteUser')->name('perfil.usuario.delete');
    //Route::post('perfil/{id}/usuario/cadastrar',      'Security\PerfilController@addUsuarios')->name('perfil.usuario.add');
   // Route::get('perfil/{id}/usuario/cadastrar',       'Security\PerfilController@usuariosParaAdd')->name('perfil.usuario.cadastrar');
  //  Route::get('perfil/{id}/usuario',                 'Security\PerfilController@usuarios')->name('perfil.usuario');







//==============================================================================================================
//                              SEGURANCA PERMISSAO
//==============================================================================================================
Route::post('permissao/{permissaoId}/perfis/datatable',  'PermissaoController@BuscarPerfisDataTable'); 
Route::post('permissao/datatable',                       'PermissaoController@getDatatable')->name('permissao.datatable');  
Route::resource('permissao',                             'PermissaoController')->except(['create', 'edit']); 


