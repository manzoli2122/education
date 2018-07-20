<?php

namespace App\Service\Security ;

use App\Service\VueServiceInterface;

  
interface UsuarioServiceInterface  extends VueServiceInterface    
{
   
    public function  BuscarPerfilDataTable( $request , $id );

    public function adicionarPerfilAoUsuario( $perfil , $userId );

    public function adicionarPerfilAoUsuarioLog( $request , $perfil , $userId );

    public function  BuscarPerfilDataTableLog( $request , $id );
} 