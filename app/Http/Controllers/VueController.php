<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 
use View; 
use Exception ;
use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Logging\LogService;


class VueController extends Controller
{
 
    protected $service;     
    protected $view   ;
    protected $model_name = 'Model'   ;


    protected $logservice   ;

      
    // public function __construct( LogService $service ){ 
    //     $this->logservice = $service ;   
    // }





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

            try {
                $this->logservice->enviar( [ 'acao' => 'Visualizado', 'model' => $this->model_name,  'id' => $id , 'usuario' => Auth::user()->name ] )  ;
            }
            catch(Exception $e) {    
                Log::info($e);  
            }

            //Log::channel('slack')->info('Visualizando ' . $this->model_name . ' id = '. $id , ['id' => $id , 'usuario' => Auth::user()->name ] );
            return response()->json( $model , 200);
        }         
        catch(Exception $e) {    
            Log::info($e);       
            return response()->json( 'Erro interno'  , 500);    
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
            try {
                $this->logservice->enviar( [ 'acao' => 'Cadastro', 'model' => $this->model_name , 'usuario' => Auth::user()->name ,  'dados' => $request->all() ] )  ;
            }
            catch(Exception $e) {    
                Log::info($e);  
            }
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
            try {
                $this->logservice->enviar( [ 'acao' => 'Exclusão', 'model' => $this->model_name , 'usuario' => Auth::user()->name ,  'id' => $id ] )  ;
            }
            catch(Exception $e) {    
                Log::info($e);  
            }
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
