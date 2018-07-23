<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 
use View; 
use Exception ;
use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\QueryException;


class VueController extends Controller
{
 
    protected $service;     
    protected $view   ;



    public function index(Request $request){  
        return view("{$this->view}.index");         
    }




    /**
    * Função para buscar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function show(Request $request , $id){
        try {  
            if( !$model = $this->service->BuscarPeloId( $id ) ){       
                return response()->json('Item não encontrado.', 404 );    
            }                   
            return response()->json( $model , 200);
        }         
        catch(Exception $e) {           
            return response()->json( 'Erro interno', 500);    
        }
    }





    /**
    * Função para atualizar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function update(Request $request ,  $id )
    {        
        $this->validate( $request  , $this->service->validacoes() );  
        try{
            $this->service->Atualizar( $request ,  $id);
        } 
        catch(ModelNotFoundException $e){
            return response()->json( $e->getMessage() , 404);
        } 
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        } 
        return response()->json( 'Atualização realizada com sucesso' , 200); 
    }
    




    /**
    * Função para criar um model
    *
    * @param Request $request
    *   
    * @return json
    */
    public function store(Request $request)
    {
        $this->validate( $request  , $this->service->validacoes() );  
        try{
            $this->service->Salvar( $request );
        }  
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        }   
        return response()->json( 'Cadastro realizado com sucesso' , 200); 
    }





    /**
    * Função para excluir um model
    *
    * @param Request $request
    *   
    * @param int  $id
    *    
    * @return json
    */
    public function destroy( Request $request, $id)
    { 
        try{
            $this->service->Apagar($id);
            return response()->json( 'Exclusão realizada com sucesso' , 200); 
        } 
        catch(ModelNotFoundException $e){
            return response()->json( $e->getMessage() , 404);
        } 
        catch(QueryException $e){
            return response()->json([ 'message' => 'Erro de conexao com o banco' ] , 500 );
        } 
        catch(Exception $e){
            return response()->json([ 'message' => $e->getMessage() ], 500);
        }  
    }




    /**
    * Função para buscar models para datatable
    *
    * @param Request $request
    *   
    * @return json
    */
    public function getDatatable( Request $request ){
        try {            
            return  $this->service->BuscarDataTable( $request);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        } 
    }

  
}
