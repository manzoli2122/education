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
  

  	/**
    * Função para buscar models para datatable  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  BuscarDataTable( $request ){ 
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
           ->addColumn('action', function($linha) {
            return  '<a href="#/edit/'.$linha->id.'" btn-edit class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
            .'<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar"><i class="fa fa-search"></i></a>';
             })
            ->make(true);  
    }

  
}
