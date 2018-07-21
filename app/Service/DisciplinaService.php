<?php

namespace App\Service ;
 
use App\Models\Disciplina;
use Yajra\DataTables\DataTables;
use App\Exceptions\ModelNotFoundException;

class DisciplinaService extends VueService  implements DisciplinaServiceInterface 
{

    protected $model; 
    protected $dataTable;  

    public function __construct(Disciplina $disciplina , DataTables $dataTable){        
        $this->model = $disciplina; 
        $this->dataTable = $dataTable;      
    }
  
  
}
