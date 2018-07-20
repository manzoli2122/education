<?php

namespace App\Service\Security ;
 
use App\User;
use App\Models\Perfil;
use App\Models\Security\LogUsuarioPerfil;
use App\Service\VueService;
use Auth;
use Yajra\DataTables\DataTables;


class UsuarioService extends VueService  implements UsuarioServiceInterface 
{

    protected $model; 
    protected $perfil; 
    protected $log;
    protected $dataTable;
    protected $route = "user";


    public function __construct( User $user , Perfil $perfil , LogUsuarioPerfil $log , DataTables $dataTable){        
        $this->dataTable = $dataTable ;   
        $this->model = $user ;   
        $this->perfil = $perfil ;
        $this->log = $log ;    
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
        $models = $this->perfil->getPerfilDatatable($id);
        
         
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  
                '<button data-id="'.$linha->id.'" vonclick="ExcluirPerfil('.$linha->id.')" btn-excluir class="btn btn-danger btn-sm" title="Excluir" style="margin-left: 10px;"><i class="fa fa-trash"></i></button>'
                //.'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis" style="margin-left: 10px;"> <i class="fa fa-id-card"></i>  </a> ' 
            ;
        })
         
        ->make(true);
        return $result ;
        
       
       

    }



    public function  BuscarPerfilDataTableLog( $request , $id ){
        
        $models = $this->log->getDatatable($id);   

        return $this->dataTable
                ->eloquent($models)
               // ->addColumn('title', function (User $user) {
                //    return $user->onePost ? str_limit($user->onePost->title, 30, '...') : '';
               // })
                ->make(true);


        //$result = \Yajra\DataTables\DataTables::of($models)  
       // ->make(true);
     //   return $result ;
         
    }







    public function adicionarPerfilAoUsuario( $perfil , $userId )
    {        
        $usuario = $this->model->find($userId);
        $perfil = $this->perfil->find( $perfil );
        if( $perfil->nome != 'Admin' or Auth::user()->hasPerfil('Admin'))
            $usuario->attachPerfil($perfil);
 
    }



    public function adicionarPerfilAoUsuarioLog( $request , $perfil , $userId )
    {        

        $log =  new LogUsuarioPerfil();
        $log->user_id = $userId;
        $log->autor_id = Auth::user()->id;
        $log->perfil_id = $perfil;
        $log->acao = 'adicionar';
        $log->ip_v4 = '12.12.12.12';
        $log->host = '13.13.13.13';
        
        //$this->perfis()->attach($perfil);
        
        $log->save();

       
 
    }





 
  
  
}
