<?php

namespace App\Service ;
 
use App\Models\Disciplina;

use App\Exceptions\ModelNotFoundException;

class DisciplinaService extends VueService  implements DisciplinaServiceInterface 
{

    protected $model;   

    public function __construct(Disciplina $disciplina){        
        $this->model = $disciplina;    
    }
  
  
}
