<?php

namespace App\Service\Security ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request;
  
interface UsuarioServiceInterface  extends VueServiceInterface    
{



    /**
    * Função para ativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Ativar( Request $request , $id );  
   


    /**
    * Função para desativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Desativar( Request $request , $id );



    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilDataTable( $request , $userId );


    /**
    * Função para buscar os logs de perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilDataTableLog( $request , $userId );



    /**
    * Função para Adicionar um Perfil a um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPerfilAoUsuario( int $perfilId , string $userId , Request  $request);


    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPerfilDoUsuario( int $perfilId , string $userId , Request  $request );

    


    /**
    * Função para buscar os Perfis que um usuario não possui; 
    *  
    * @param int  $userId 
    *
    * @return List $pefis
    */
    public function BuscarPerfisParaAdicionar(   string $userId  );






    /**
    * Função para buscar log de perfis do usuario
    *
    * @param Request $request
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function elasticsearch( Request $request , $userId  );






    /**
    * Funcao para buscar os usuario pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarUsuarioMinhaOMEDataTable( $request );



    /**
    * Função para buscar os Perfis que um usuario não possui; 
    *  
    * @param int  $userId 
    *
    * @return List $pefis
    */
    public function BuscarPerfisParaTransferir(   string $userId  );



    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilTransferirDataTable( $request , $userId );
    
} 