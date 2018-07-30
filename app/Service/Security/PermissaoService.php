<?php

namespace App\Service\Security ;
 
use App\Models\Security\Permissao; 
use Yajra\DataTables\DataTables;
use App\Service\VueService;
use Cache;
use App\Jobs\ProcessPermissao;
use Log;
use App\Logging\LogService;

class PermissaoService extends VueService  implements PermissaoServiceInterface 
{

    protected $model;   
    protected $dataTable;
    protected $logservice ;


    public function __construct( Permissao $permissao , DataTables $dataTable , LogService $servicelog ){     
        $this->logservice = $servicelog  ;    
        $this->model = $permissao ;    
        $this->dataTable = $dataTable ; 
    }
  


    /**
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar1( $request  ){
        
        throw_if( !$insert  = $this->model->create( $request->all() ) , Exception::class);  
        
        //Log::info($insert->nome);
        dispatch( new ProcessPermissao( $insert , $this->logservice ));
        //$teste = new ProcessPermissao( ['nome' => $insert->nome ] );
        //$teste->dispatch( );
    }



 


    /**
    * Função para excluir um model  e limpar a cache
    * neccesário pois um perfil pode ficar com a permissao 
    * mesmo depois dela ser excluida
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
                        '<a href="#/'.$linha->id.'/perfis" class="btn btn-warning btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a>'
                       .'<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
                       .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>';
            })
            ->make(true); 
    }



    /**
    * Função para buscar as Perfis de uma Permissao pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */
    public function  BuscarPerfisDataTable( $request , $permissaoId ){ 
        $permissao = $this->model->find($permissaoId); 
        $models = $permissao->perfis( );  
        return $this->dataTable
            ->eloquent($models) 
            ->make(true);  
    }

  
}
