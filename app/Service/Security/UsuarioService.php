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


    /**
    * Save  
    *
    * @param mixed $inputPermissions
    *
    * @return void
    */
    public function __construct( User $user , Perfil $perfil , LogUsuarioPerfil $log , DataTables $dataTable){        
        $this->dataTable = $dataTable ;   
        $this->model = $user ;   
        $this->perfil = $perfil ;
        $this->log = $log ;    
    }





    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        return $this->dataTable
            ->eloquent($models)
            ->addColumn('action', function($linha) {
                return'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a> ';
            })
            ->make(true); 
    }







    public function  BuscarPerfilDataTable( $request , $id ){ 
        $usuario = $this->model->find($id); 
        $models = $usuario->getPerfilDatatable( ); 
        return $this->dataTable
            ->eloquent($models)
            ->addColumn('action', function($linha) {
                return  
                '<button data-id="'.$linha->perfil_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
            ;
            })
            ->make(true);  
    }







    public function  BuscarPerfilDataTableLog( $request , $id ){
        
        $models = $this->log->getDatatable($id);  
        return $this->dataTable
                ->eloquent($models)
                ->make(true);
 
    }









    /**
    * Função para Adicionar um Perfil a um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPerfilAoUsuario( int $perfilId , int  $userId , int $autorId  , string $ip_v4 , string $host)
    {        
        $usuario = $this->model->find($userId);
        $perfil = $this->perfil->find( $perfilId );
        if( $perfil->nome != 'Admin' or Auth::user()->hasPerfil('Admin')){
            $usuario->attachPerfil($perfil);
            $this->adicionarPerfilAoUsuarioLog( $perfilId , $userId  , Auth::user()->id , 'Adicionar' , $ip_v4 , $host );
        } 
    }
 







    
    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPerfilDoUsuario( int $perfilId , int  $userId , int $autorId  , string $ip_v4 , string $host)
    {        
        $usuario = $this->model->find($userId);
        $perfil = $this->perfil->find($perfilId); 
        if( $perfil->nome == 'Admin' and ! Auth::user()->hasPerfil('Admin')){
            return response()->json( 'Voce não tem permissão para isso' , 500); 
        } 
        $usuario->detachPerfil($perfilId); 
        $this->adicionarPerfilAoUsuarioLog( $perfilId , $userId  , Auth::user()->id , 'Excluir' , $ip_v4 , $host ); 
    }









    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    * 
    * @param string  $acao
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    private function adicionarPerfilAoUsuarioLog( int $perfilId , int $userId  , int $autorId , string $acao , string $ip_v4 , string $host )
    {         
        $log =  new LogUsuarioPerfil();
        $log->user_id = $userId;
        $log->autor_id = $autorId;
        $log->perfil_id = $perfilId;
        $log->acao = $acao ;
        $log->ip_v4 = $ip_v4;
        $log->host = $host; 
        $log->save(); 
    }





 
  
  
}
