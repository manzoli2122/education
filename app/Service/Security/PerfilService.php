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
                    .'<a href="#/'.$linha->id.'/permissao" class="btn btn-primary btn-sm" title="Permissões" style="margin-left: 10px;"> <i class="fa fa-id-card"></i>  </a> ' 
                    //. '<a href="#/'.$linha->id .'/permissao" class="btn btn-warning btn-sm" title="Permissões" style="margin-left: 10px;"> <i class="fa fa-unlock"></i> Permissões </a> ' 
                   // . '<a href="#/'.$linha->id .'/usuario" class="btn btn-secondary btn-sm" title="Usuários"> <i class="fa fa-users"></i> Usuários </a> '
            ;
        })->make(true);
        return $result ; 
    }
  





    

    public function  BuscarPermissaoDataTable( $request , $id ){
        
        $models = $this->model->getPermissaoDatatable($id); 
         
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  
                '<button data-id="'.$linha->id.'" vonclick="ExcluirPerfil('.$linha->id.')" btn-excluir class="btn btn-danger btn-sm" title="Excluir" style="margin-left: 10px;"><i class="fa fa-trash"></i></button>'
                ;
        })
        
        ->make(true);
        return $result ;
        
       


    }


  
}
