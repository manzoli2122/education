<?php

namespace App\Http\Controllers ;
 

use App\Models\Disciplina;

use App\Service\DisciplinaServiceInterface;

use Illuminate\Http\Request;

use View;

use App\Exceptions\ModelNotFoundException;

use Exception;


class DisciplinaController extends VueController
{ 

    protected $service;   
    
    protected $name = "Disciplina";    
    
    protected $view = 'disciplina' ;
    
    



    public function __construct(  DisciplinaServiceInterface $service ){  
            
        $this->service = $service;         

        $this->middleware('auth');
        $this->middleware('permissao:disciplina-cadastrar')->except('disciplinas'); 
    }

 

    public function disciplinas(){  
        $disciplina = Disciplina::select('id', 'nome' )->get();
        return response()->json(  $disciplina , 200);
    }
 
    
 

}
