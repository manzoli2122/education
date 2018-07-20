<?php

namespace App\Service\Security ;

use App\Service\VueServiceInterface;
  
interface PerfilServiceInterface  extends VueServiceInterface    
{
    public function  BuscarPermissaoDataTable( $request , $id );
} 