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


    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  
                '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-datatable btn-sm" title="Editar" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>'
                .'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis" style="margin-left: 10px;"> <i class="fa fa-id-card"></i>  </a> ' 
            ;
        })->make(true);
        return $result ; 
    }






    public function  BuscarPerfilDataTable( $request , $id ){
        $models = $this->model->getPerfilDatatable($id);
        
         
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  
                '<button data-id="'.$linha->id.'" vonclick="ExcluirPerfil('.$linha->id.')" btn-excluir class="btn btn-danger btn-sm" title="Excluir" style="margin-left: 10px;"><i class="fa fa-trash"></i></button>'
                //.'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis" style="margin-left: 10px;"> <i class="fa fa-id-card"></i>  </a> ' 
            ;
        })
        //->parameters([
        //    'buttons' => ['reload'],
        //])
        ->make(true);
        return $result ;
        
       
       /* $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  
                '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-datatable btn-sm" title="Editar" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>'
                .'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis" style="margin-left: 10px;"> <i class="fa fa-id-card"></i>  </a> ' 
            ;
        })
        ->make(true);
        return $result ; 
        */


    }

 
  
  
}
