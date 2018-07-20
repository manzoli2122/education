<?php

namespace App\Service ; 

use App\Exceptions\ModelNotFoundException;

class VueService implements VueServiceInterface 
{

    protected $model;   


    public function  BuscarPeloId( $id ){
        return   $this->model->find($id)  ;
    }


    public function  Atualizar( $request , $id){ 
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class); 
        throw_if( !$update = $model->update($request->all()) , Exception::class); 
    }


    public function  Salvar( $request  ){
        throw_if( !$insert  = $this->model->create( $request->all() ) , Exception::class);  
    }


    public function  validacoes(){
        return $this->model->rules();
    }  


    public function  Apagar( $id ){
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class); 
        throw_if( !$delete = $model->delete()  , Exception::class);  
    }


    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        $result = \Yajra\DataTables\DataTables::of($models)
        ->addColumn('action', function($linha) {
            return  '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-datatable btn-sm" title="Editar" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>'
            . '<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-datatable btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
            ;
        })->make(true);
        return $result ; 
    }




 
    public function  ValidarCriacao( $entity ){}
    public function  ValidarAtualizacao( $entity ){}
    public function  ValidarExclusao( $entity ){}
    
   // public function  BuscarPeloId( $id ); 
    
    
    //public function  getDAO(){}
    public function  Autorizar(){}
    public function  BuscarQuantidade(){}
    
   // public function  Buscar( );
    //public function  ConjuntoDeDados(){}
   // public function  EntityExists($id){}

 
} 