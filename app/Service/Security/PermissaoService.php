<?php

namespace App\Service\Security ;
 
use App\Models\Permissao;

use App\Service\VueService;

class PermissaoService extends VueService  implements PermissaoServiceInterface 
{

    protected $model;   

    public function __construct( Permissao $permissao){        
        $this->model = $permissao ;    
    }
  
  
}
