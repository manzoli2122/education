<?php

namespace App\Service\Seguranca ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request;
  
interface PerfilServiceInterface  extends VueServiceInterface    
{
 


    /**
    * Função para Adicionar uma Permissao a um Perfil e salvar em log 
    *
    * @param int  $permissaoId
    *  
    * @param int  $perfilId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPermissaoAoPerfil( int $permissaoId , int $perfilId  , Request  $request);




    /**
    * Função para retirar uma Permissao de um Perfil e salvar em log 
    *
    * @param int  $permissaoId
    *  
    * @param int  $perfilId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPermissaoDoPerfil( int $permissaoId , int $perfilId , Request  $request );




    /**
    * Função para buscar os Permissao que um Perfil não possui; 
    *  
    * @param int  $perfilId 
    *
    * @return List $permissoes
    */
    public function BuscarPermissoesParaAdicionar(   int $perfilId  );



    /**
    * Função para buscar os permissoes de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarPermissaoDataTable( $request , $perfilId );



    /**
    * Função para buscar os logs de permissoes de um perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarPermissaoDataTableLog( $request , $perfilId );

    


    /**
    * Função para buscar os Usuarios de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarUsuariosDataTable( $request , $perfilId );
} 