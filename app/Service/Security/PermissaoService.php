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
    * Funcao para buscar os usuario pelo datatable  
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
                   	'<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>' 
                    //.'<a href="#/'.$linha->id.'/permissao" class="btn btn-primary btn-sm" title="Permissões"><i class="fa fa-unlock"></i></a> '.

                    //'<a href="#/'.$linha->id.'/usuarios" class="btn btn-warning btn-sm" title="Usuarios"><i class="fa fa-users"></i></a> '

                    // . '<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar"><i class="fa fa-search"></i></a>' 
                    ;
            })
            ->make(true); 
    }

  
}
