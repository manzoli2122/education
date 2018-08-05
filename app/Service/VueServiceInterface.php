<?php

namespace App\Service ;

use Illuminate\Http\Request; 

interface VueServiceInterface  
{
    
    /**
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( Request $request , $id );


    /**
    * Função para atualizar um model ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Atualizar( Request $request , $id );  



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
    public function  Apagar( Request $request, $id );  





    /**
    * Função para buscar models para datatable  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  BuscarDataTable( $request );
 

    public function  ValidarCriacao(  ); 
    public function  ValidarAtualizacao( $entity );   
    public function  ValidarExclusao( $entity );   
    
    public function  Autorizar();  
    public function  BuscarQuantidade();  
     
 
} 