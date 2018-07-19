<?php

namespace App\Service\Security ;

use App\Service\VueServiceInterface;
  
interface UsuarioServiceInterface  extends VueServiceInterface    
{
   
    public function  BuscarPerfilDataTable( $request , $id );


} 