<?php

namespace App\Service ; 

use App\Exceptions\ModelNotFoundException; 

class VueService implements VueServiceInterface 
{

    protected $model;   
    protected $dataTable;

 


    /**
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( $id ){
        return   $this->model->find($id)  ;
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
    public function  Apagar( $id ){
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class); 
        throw_if( !$delete = $model->delete()  , Exception::class);  
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







 
    public function  ValidarCriacao( $entity ){}
    public function  ValidarAtualizacao( $entity ){}
    public function  ValidarExclusao( $entity ){}
     
     
    public function  Autorizar(){}
    public function  BuscarQuantidade(){}
     

 
} 