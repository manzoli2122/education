<?php
 
namespace  App\Http\Controllers\Security;

use Illuminate\Http\Request;  
use App\Http\Controllers\VueController; 
use App\Service\Security\UsuarioServiceInterface;  
use Exception;
 

class UsuarioController extends VueController
{
    
    protected $service; 


    protected $view  = " usuario";




    
    public function __construct( UsuarioServiceInterface $service    ){ 
        $this->service = $service ;   
        $this->middleware('auth'); 
        $this->middleware('permissao:usuarios');  
        $this->middleware('perfil:Admin')->only('update', 'destroy' , 'excluirPerfilDoUsuario' , 'adicionarPerfilAoUsuario'); 
 
    }

  
     




    /**
    * Função para ativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Ativar( Request $request , $userId ){
        return response()->json( $this->service->Ativar( $request , $userId ), 200 );
    }








    /**
    * Função para desativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Desativar( Request $request , $userId ){
       return response()->json( $this->service->Desativar( $request , $userId ), 200 );
    }









    /**
    * Função para Adicionar um Perfil a um usuario atraves do UsuarioServiceInterface
    *
    * @param Request $request
    *  
    * @param int  $userId
    *    
    * @return json
    */
    public function adicionarPerfilAoUsuario(Request $request , $userId)
    {     
        if( $request->get('perfil') != '' ){  
           $this->service->adicionarPerfilAoUsuario( $request->get('perfil'), $userId, $request); 
        }   
        return response()->json($this->service->BuscarPerfisParaAdicionar( $userId ),200);
    }


 



    


    /**
    * Função para retirar um Perfil de um usuario  atraves do UsuarioServiceInterface
    *
    * @param Request $request
    * 
    * @param int  $perfilId
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function excluirPerfilDoUsuario( Request $request , $userId , $perfilId )
    {        
        $this->service->excluirPerfilDoUsuario($perfilId , $userId ,  $request  );  
        return response()->json( $this->service->BuscarPerfisParaAdicionar( $userId )  , 200);  
    }











    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function BuscarPerfilDataTable( Request $request , $userId )
    {     
        try {            
            return  $this->service->BuscarPerfilDataTable( $request , $userId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }










    /**
    * Função para buscar os logs de perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function BuscarPerfilDataTableLog( Request $request , $userId )
    {     
        try {            
            return  $this->service->BuscarPerfilDataTableLog( $request , $userId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }

 








     /**
    * Função para buscar os perfis que o usuario ainda não tem
    * 
    * @param int  $userId 
    *
    * @return List $perfis
    */
    public function BuscarPerfisParaAdicionar($userId)
    {    
        try {            
            return response()->json( $this->service->BuscarPerfisParaAdicionar( $userId ) , 200);
        }         
        catch(Exception $e) {           
            return response()->json( $e, 500);    
        }   
    }
    
 







    /**
    * Função para buscar log de perfis do usuario
    *
    * @param Request $request
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function elasticsearch( Request $request , $userId  )
    {        
        $response = $this->service->elasticsearch(   $request , $userId  ); 
 
        return response()->json( $response  , 200); 
         
    }





    
}