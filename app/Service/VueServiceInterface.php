<?php

namespace App\Service ;
  
interface VueServiceInterface  
{
    
    public function  BuscarPeloId( $id );
    public function  Atualizar( $request , $id );  
    public function  Salvar( $request  ); 
    public function  validacoes();   
    public function  Apagar( $id );  
    public function  BuscarDataTable( $request );




    public function  ValidarCriacao( $entity ); 
    public function  ValidarAtualizacao( $entity );   
    public function  ValidarExclusao( $entity );   
   
     
   
    
    //public function  getDAO();  
    public function  Autorizar();  
    public function  BuscarQuantidade();  
    
   // public function  Buscar( );
   // public function  ConjuntoDeDados();
   // public function  EntityExists($id);
 
} 