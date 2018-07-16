<?php

namespace App\Service\Security ;
 
use App\User;

use App\Service\VueService;

class UsuarioService extends VueService  implements UsuarioServiceInterface 
{

    protected $model; 
    
    protected $route = "user";


    public function __construct( User $user){        
        $this->model = $user ;    
    }


 
  
  
}
