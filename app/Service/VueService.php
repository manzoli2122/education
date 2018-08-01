<?php

namespace App\Service ; 

use App\Exceptions\ModelNotFoundException; 
use Illuminate\Http\Request; 
use App\Jobs\CrudProcessJob;
use Auth;
use Log;


class VueService  implements VueServiceInterface  
{

    
    protected $model;   
    protected $dataTable;
    protected $logservice ;
 


    /**
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( Request $request , $id ){ 
        $model = $this->model->find($id)  ;

        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user(),
        ] ;

        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                get_class( $this->model ),    
                'Visualizacao' ,  
                $model->log()  , 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u') 
            )
        );  

        return   $model   ; 
    }






    /**
    * Função para atualizar um model ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Atualizar( $request , $id){ 
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class); 
        throw_if( !$update = $model->update($request->all()) , Exception::class); 

        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user(),
        ] ;

        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                get_class( $this->model ),   
                'Atualizacao' ,  
                $model->log()  , 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u')  
            )
        );   

        return $model;
    }





    /**
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar( $request  ){
        
        throw_if( !$insert  = $this->model->create( $request->all() ) , Exception::class); 

        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user(),
        ] ;

        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                get_class( $this->model ),     
                'Cadastro' ,  
                $insert->log() , 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u') 
            )
        );   




        // try {
            //     $this->logservice->enviar(   
            //         [ 
            //             'acao' =>'Cadastro' , 
            //             'model' => get_class( $this->model ) ,     
            //             'dados' => $insert->log() ,     
            //             'info' =>  $info , 
            //             'data' => now()->format('Y-m-d\TH:i:s.u')  
            //         ] 
            //     )  ;
            // }
            // catch(Exception $e) {    
            //     Log::info($e);  
            // }
 
        return $insert ;  
    }

    





    /**
    * Função para buscar as validacoes do modelo 
    * 
    * @return $rules
    */
    public function  validacoes(){
        return $this->model->rules();
    }  







    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class);  
        
        $dados = $model->log();

        throw_if( !$delete = $model->delete()  , Exception::class);   
 
        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user(),
        ] ;
         
        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                get_class( $this->model ),   
                'Exclusão' ,  
                $dados, 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u') 
            )
        );   
 
    }





    /**
    * Função para buscar models para datatable  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  BuscarDataTable( $request ){ 
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
           ->addColumn('action', function($linha) {
            return  '<a href="#/edit/'.$linha->id.'" btn-edit class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            .'<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar"><i class="fa fa-search"></i></a>';
             })
            ->make(true);  
    }







 
    
    public function  ValidarAtualizacao( $entity ){}
    public function  ValidarExclusao( $entity ){}
    public function  ValidarCriacao(  ){}
     
    public function  Autorizar(){}
    public function  BuscarQuantidade(){}
     

 
} 