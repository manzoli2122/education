<?php

namespace App\Service ;
  
interface VueServiceInterface  
{
    
    /**
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( $id );


     /**
    * Função para atualizar um model ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Atualizar( $request , $id );  



    /**
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar( $request  ); 





    /**
    * Função para buscar as validacoes do modelo 
    * 
    * @return $rules
    */
    public function  validacoes();  




    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */ 
    public function  Apagar( $id );  





    /**
    * Função para buscar models para datatable  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  BuscarDataTable( $request );
 

    public function  ValidarCriacao( $entity ); 
    public function  ValidarAtualizacao( $entity );   
    public function  ValidarExclusao( $entity );   
    
    public function  Autorizar();  
    public function  BuscarQuantidade();  
     
 
} 