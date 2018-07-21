<?php

namespace App\Service\Security ;

use App\Service\VueServiceInterface;

  
interface UsuarioServiceInterface  extends VueServiceInterface    
{
   
    public function  BuscarPerfilDataTable( $request , $id );





    /**
    * Função para Adicionar um Perfil a um usuario e salvar em log 
    *
    * @param mixed $inputPermissions
    *
    * @return void
    */
    public function adicionarPerfilAoUsuario( int $perfilId , int $userId , int $autorId  , string $ip_v4 , string $host);


    public function excluirPerfilDoUsuario( int $perfilId , int $userId , int $autorId  , string $ip_v4 , string $host);



   // public function adicionarPerfilAoUsuarioLog( $request , $perfil , $userId );

    public function  BuscarPerfilDataTableLog( $request , $id );
} 