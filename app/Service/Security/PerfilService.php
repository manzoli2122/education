<?php

namespace App\Service\Security ;
 
use App\Models\Perfil;

use App\Service\VueService;

class PerfilService extends VueService  implements PerfilServiceInterface 
{

    protected $model; 
    
    protected $route = "perfil";


    public function __construct( Perfil $perfil){        
        $this->model = $perfil ;    
    }



    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-datatable btn-sm" title="Editar" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>'
                    . '<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-datatable btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
                    . '<a href="#/'.$linha->id .'/permissao" class="btn btn-warning btn-sm" title="Permissões" style="margin-left: 10px;"> <i class="fa fa-unlock"></i> Permissões </a> ' 
            ;
        })->make(true);
        return $result ; 
    }
  
  
}
