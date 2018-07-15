<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 
use View; 
use Exception ;
use App\Exceptions\ModelNotFoundException;



class VueController extends Controller
{

        

    protected $service;   
    
    protected $name  ;    
    
    protected $view   ;



    public function index(Request $request){          
        return view("{$this->view}.index");         
    }



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




    public function destroy( Request $request, $id)
    { 
        try{
            $this->service->Apagar($id);
            return response()->json( 'Exclusão realizada com sucesso' , 200); 
        } 
        catch(ModelNotFoundException $e){
            return response()->json( $e->getMessage() , 404);
        } 
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        }  
    }





    public function getDatatable( Request $request ){
        try {            
            return  $this->service->BuscarDataTable( $request);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        } 
    }

  
}
