<?php

namespace App\Service\Seguranca ;

use App\Service\VueServiceInterface;
  
interface PermissaoServiceInterface  extends VueServiceInterface    
{

    /**
    * Função para buscar as Perfis de uma Permissao pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */
    public function  BuscarPerfisDataTable( $request , $permissaoId );
   
} 