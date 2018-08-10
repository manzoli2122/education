<?php
 
namespace  App\Http\Controllers\Seguranca;

use Illuminate\Http\Request;  
use App\Http\Controllers\Controller; 
use App\Service\Seguranca\UsuarioServiceInterface;  
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrasferirPerfilController extends Controller
{
    
    protected $service; 
 
    protected $view  = "seguranca.usuario";
 
    
    public function __construct( UsuarioServiceInterface $service    ){ 
        $this->service = $service ;   
        $this->middleware('auth'); 
         
    }

    
    public function index(Request $request){  
        return view("{$this->view}.transferirPerfil");         
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
            if( !$model = $this->service->BuscarUsuarioMinhaOmePeloId(  $request , $id ) ){       
                return response()->json('Item não encontrado.', 404 );    
            } 
            return response()->json( $model , 200); 
        }  
        catch(Exception $e) {  
            return response()->json( 'Erro Interno '  , 500);    
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
            return  $this->service->BuscarUsuarioMinhaOMEDataTable( $request);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        } 
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
        return response()->json($this->service->BuscarPerfisParaTransferir( $userId ),200);
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
        return response()->json( $this->service->BuscarPerfisParaTransferir( $userId )  , 200);  
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
            return response()->json( $this->service->BuscarPerfisParaTransferir( $userId ) , 200);
        }         
        catch(Exception $e) {           
            return response()->json( $e, 500);    
        }   
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
            return  $this->service->BuscarPerfilTransferirDataTable( $request , $userId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }

 
 

    
}