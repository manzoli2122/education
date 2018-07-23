<?php

namespace App\Service\Security ;
 
use App\Models\Security\Perfil;
use App\Models\Security\Permissao;
use Yajra\DataTables\DataTables;
use App\Service\VueService;
use App\Models\Security\LogPerfilPermissao;
use Auth;
use Cache;


class PerfilService extends VueService  implements PerfilServiceInterface 
{

    protected $model; 
    protected $permissao; 
    protected $dataTable;
    protected $logSeguranca;
    protected $route = "perfil";




    public function __construct( Perfil $perfil , Permissao $permissao, LogPerfilPermissao $log , DataTables $dataTable){        
        $this->model = $perfil ;    
        $this->permissao = $permissao ;  
        $this->dataTable = $dataTable ;    
        $this->logSeguranca = $log ; 
    }

 


    /**
    * Função para excluir um model  e limpar a cache
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( $id ){ 
        parent::Apagar( $id ) ;  
        Cache::flush(); 
    }



    /**
    * Função para Adicionar uma Permissao a um Perfil e salvar em log 
    *
    * @param int  $permissaoId
    *  
    * @param int  $perfilId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPermissaoAoPerfil( int $permissaoId , int $perfilId , int $autorId  , string $ip_v4 , string $host){
        $perfil = $this->model->find($perfilId);
        $permissao = $this->permissao->find( $permissaoId ); 
        $perfil->attachPermissao($permissao);

        $this->Log( $perfilId , $permissaoId , $permissao->nome  , Auth::user()->id , 'Adicionar' , $ip_v4 , $host );
    }

    






    /**
    * Função para retirar uma Permissao de um Perfil e salvar em log 
    *
    * @param int  $permissaoId
    *  
    * @param int  $perfilId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPermissaoDoPerfil( int $permissaoId , int $perfilId , int $autorId  , string $ip_v4 , string $host){
        $perfil = $this->model->find($perfilId);
        $permissao = $this->permissao->find($permissaoId);  
        $perfil->detachPermissao($permissao); 
        $this->Log( $perfilId  , $permissaoId , $permissao->nome , Auth::user()->id , 'Excluir' , $ip_v4 , $host ); 
    }




    /**
    * Função para buscar os Permissao que um Perfil não possui; 
    *  
    * @param int  $perfilId 
    *
    * @return List $permissoes
    */
    public function BuscarPermissoesParaAdicionar(   int $perfilId  ){
         return  $this->permissao->permissaoParaAdicionarAoPerfil( $perfilId );
    }







    /**
    * Função para buscar os Usuarios de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarUsuariosDataTable( $request , $perfilId ){ 
        $perfil = $this->model->find($perfilId); 
        $models = $perfil->usuarios( );  
        return $this->dataTable
            ->eloquent($models) 
            ->make(true);  
    }





    /**
    * Função para buscar os permissoes de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarPermissaoDataTable( $request , $perfilId ){
        
        $perfil = $this->model->find($perfilId); 
        $models = $perfil->permissoes( );  
        return $this->dataTable
            ->eloquent($models)
            ->addColumn('action', function($linha) {
                return  '<button data-id="'.$linha->permissao_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' ;
            })
            ->make(true);  
    }





    /**
    * Função para buscar os logs de permissoes de um perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function  BuscarPermissaoDataTableLog( $request , $perfilId ){
        $models = $this->logSeguranca->getDatatable($perfilId);  
        return $this->dataTable
                ->eloquent($models)
                ->editColumn('created_at', function ($log) {
                    return $log->created_at->format('d/m/Y');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
                })
                ->make(true); 
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
                    '<a href="#/'.$linha->id.'/permissao" class="btn btn-primary btn-sm" title="Permissões"><i class="fa fa-unlock"></i></a>'
                    .'<a href="#/'.$linha->id.'/usuarios" class="btn btn-warning btn-sm" title="Usuarios"><i class="fa fa-users"></i></a> '
                    .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' ;
            })
            ->make(true); 
    }
 
    



    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $pemissaoId
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
    private function Log( int $perfilId , int $permissaoId , string $permissao_nome , int $autorId , string $acao , string $ip_v4 , string $host )
    {         
        $log =  new LogPerfilPermissao();
        $log->permissao_id = $permissaoId;
        $log->permissao_nome = $permissao_nome;
        $log->autor_id = $autorId;
        $log->perfil_id = $perfilId;
        $log->acao = $acao ;
        $log->ip_v4 = $ip_v4;
        $log->host = $host; 
        $log->save(); 
    }


  
}
