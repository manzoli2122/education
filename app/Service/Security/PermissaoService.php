<?php

namespace App\Service\Security ;
 
use App\Models\Permissao; 
use Yajra\DataTables\DataTables;
use App\Service\VueService;

class PermissaoService extends VueService  implements PermissaoServiceInterface 
{

    protected $model;   
    protected $dataTable;



    public function __construct( Permissao $permissao , DataTables $dataTable){        
        $this->model = $permissao ;    
        $this->dataTable = $dataTable ; 
    }
  



  	 /**
    * Funcao para buscar as permissoes pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
            ->addColumn('action', function($linha) {
                return
                   	'<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>';
            })
            ->make(true); 
    }

  
}
