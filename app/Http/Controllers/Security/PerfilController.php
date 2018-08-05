<?php
 
namespace  App\Http\Controllers\Security;
 
use Illuminate\Http\Request;   
use App\Http\Controllers\VueController; 
use App\Service\Security\PerfilServiceInterface;  


class PerfilController extends VueController
{
    
    protected $service;     
    protected $view = "perfil";   
    

    public function __construct( PerfilServiceInterface $service  ){ 
        $this->service = $service ;   
        $this->middleware('auth'); 
        $this->middleware('permissao:perfis');  
        $this->middleware('perfil:Admin')->only('update', 'destroy' , 'excluirPermissaoDoPerfil' , 'adicionarPermissaoAoPerfil');   
    }




    /**
    * Função para Adicionar uma Permissao a um Perfil atraves do PerfilServiceInterface
    *
    * @param Request $request
    *  
    * @param int  $perfilId
    *    
    * @return json
    */
    public function adicionarPermissaoAoPerfil(Request $request , $perfilId)
    {        
        if( $request->get('permissao') != '' ){ 
           $this->service->adicionarPermissaoAoPerfil( $request->get('permissao') , $perfilId , $request ); 
        }   
        return response()->json($this->service->BuscarPermissoesParaAdicionar( $perfilId ),200); 
    }








    /**
    * Função para retirar um Permissao de um Perfil  atraves do PerfilServiceInterface
    *
    * @param Request $request
    * 
    * @param int  $perfilId
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */ 
    public function excluirPermissaoDoPerfil( Request $request , $perfilId , $permissaoId )
    {        
        $this->service->excluirPermissaoDoPerfil($permissaoId , $perfilId , $request  );   
        return response()->json( $this->service->BuscarPermissoesParaAdicionar( $perfilId )  , 200);  
    }

 




   /**
    * Função para buscar os Permissao que um Perfil não possui; 
    *  
    * @param int  $perfilId 
    *
    * @return List $permissoes
    */
    public function BuscarPermissoesParaAdicionar($perfilId)
    {      
        try {            
            return response()->json( $this->service->BuscarPermissoesParaAdicionar( $perfilId ) , 200);
        }         
        catch(Exception $e) {           
            return response()->json( 'Erro interno', 500);    
        }   
    }








 
    
    

     /**
    * Função para buscar as permissoes de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarPermissaoDataTable( Request $request , $perfilId )
    {     
        try {            
            return  $this->service->BuscarPermissaoDataTable( $request , $perfilId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }






    /**
    * Função para buscar as Usuarios de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarUsuariosDataTable( Request $request , $perfilId )
    {     
        try {            
            return  $this->service->BuscarUsuariosDataTable( $request , $perfilId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }




     /**
    * Função para buscar os logs de permissoes de um perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarPermissaoDataTableLog( Request $request , $perfilId )
    {     
        try {            
            return  $this->service->BuscarPermissaoDataTableLog( $request , $perfilId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }

  

}