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
    protected $logSeguranca;
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
        $this->logSeguranca = $log ;    

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
        return $this->dataTable
            ->eloquent($models)
            ->addColumn('action', function($linha) {
                return'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a> ';
            })
            ->make(true); 
    }






    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilDataTable( $request , $userId ){ 
        $usuario = $this->model->find($userId); 
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






    /**
    * Função para buscar os logs de perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilDataTableLog( $request , $userId ){ 
        $models = $this->logSeguranca->getDatatable($userId);  
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
        if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
             abort(403, 'Você não tem permissão para adicionar o perfil Admin.');
        }
        $usuario->attachPerfil($perfil);
        $this->adicionarPerfilAoUsuarioLog( $perfilId , $userId  , Auth::user()->id , 'Adicionar' , $ip_v4 , $host );  
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
        if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
             abort(403, 'Você não tem permissão para remover o perfil Admin.');
        } 
        if( $perfil->nome == 'Admin' and  Auth::user()->id === $userId ){
            abort(403, 'Não é possível remover o seu perfil Admin.'); 
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







      /**
    * Função para buscar os Perfis que um usuario não possui; 
    *  
    * @param int  $userId 
    *
    * @return List $pefis
    */
    public function BuscarPerfisParaAdicionar(   int $userId  ){ 
        return  $this->perfil->perfisParaAdicionarAoUsuario( $userId ,  Auth::user()->hasPerfil('Admin') );
    }
 
  
  
}
