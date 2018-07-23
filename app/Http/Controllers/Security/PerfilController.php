<?php
 
namespace  App\Http\Controllers\Security;
 
use Illuminate\Http\Request;  
use DataTables;
use App\Http\Controllers\VueController; 
use App\Service\Security\PerfilServiceInterface; 
use Auth; 
 


class PerfilController extends VueController
{
    
    protected $service;     
    protected $view = "perfil";   
    
    
    public function __construct( PerfilServiceInterface $service ){
        
        $this->service = $service ;   
        $this->middleware('auth'); 
        //$this->middleware('permissao:perfis');   
       
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
           $this->service->adicionarPermissaoAoPerfil($request->get('permissao'),$perfilId,Auth::user()->id, $request->server('REMOTE_ADDR'),$request->header('host'));
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
        $this->service->excluirPermissaoDoPerfil($permissaoId , $perfilId , Auth::user()->id , $request->server('REMOTE_ADDR'),$request->header('host')  );  
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

 
   
    
    
 









 

   





 








/*
        
        

        public function usuarios($id)
        {      
            try {  
                if( !$model = $this->service->BuscarPeloId( $id ) ){       
                    return response()->json('Item não encontrado.', 404 );    
                }                   
                return response()->json( $model->usuarios , 200);
            }         
            catch(Exception $e) {           
                return response()->json( 'Erro interno', 500);    
            } 
        }



        public function usuariosParaAdd($id)
        {            
            $model = $this->model->find($id);
            $users =$this->user->usuarios_sem_perfil($id);
            return view("{$this->view}.usuarios-add", compact('model','users'));
        }



        
        public function deleteUser($id,$userId)
        {            
            $model = $this->model->find($id);  
            if($model->nome != 'Admin' or Auth::user()->hasPerfil('Admin'))          
                $model->detachUsuario($userId); 
            return redirect()->route("{$this->route}.usuarios" ,$id)->with(['success' => 'Usuarios Removido com sucesso']);
        }




        public function addUsuarios(Request $request , $id)
        {            
            $model = $this->model->find($id); 
            if($model->nome != 'Admin' or Auth::user()->hasPerfil('Admin'))
                $model->attachUsuario($request->get('users'));            
            return redirect()->route("{$this->route}.usuarios" ,$id)->with(['success' => 'Usuarios vinculados com sucesso']);
        }





        public function pesquisarUsuarios(Request $request , $id)
        {            
            $dataForm = $request->except('_token');
            $model = $this->model->find($id);
            $users = $model->usuarios()->where('name','LIKE', "%{$dataForm['key']}%")
                                       ->orWhere('users.email',$dataForm['key'])->get();           
            return view("{$this->view}.usuarios", compact('model', 'dataForm', 'users'));
        }
*/










//=========================================================================================================================
//                                          PERMISSÕES
//=========================================================================================================================

        /*
        public function permissoes($id)
        {       
            try {  
                if( !$model = $this->service->BuscarPeloId( $id ) ){       
                    return response()->json('Item não encontrado.', 404 );    
                }                   
                return response()->json( $model->permissoes , 200);
            }         
            catch(Exception $e) {           
                return response()->json( 'Erro interno', 500);    
            }
              
        }


         




        public function permissoesParaAdd($id)
        {            
            $model = $this->model->find($id);
            $permissoes = $this->permissao->permissos_sem_perfil($id);    
            return view("{$this->view}.permissoes-add", compact('model','permissoes'));
        }
        




        public function deletePermissao($id,$permissaoId)
        {            
            $model = $this->model->find($id);            
            $model->detachPermissao($permissaoId); 
            return redirect()->route("{$this->route}.permissoes" ,$id)->with(['success' => 'Permissa Removida com sucesso']);
        }




        public function addPermissoes(Request $request , $id)
        {            
            $model = $this->model->find($id);            
            $model->attachPermissao($request->get('permissoes'));            
            return redirect()->route("{$this->route}.permissoes" ,$id)->with(['success' => 'Permissoes vinculados com sucesso']);
        }
        



        public function pesquisarPermissoes(Request $request , $id)
        {            
            $dataForm = $request->except('_token');
            $model = $this->model->find($id);
            $permissoes = $model->permissoes()->where('nome','LIKE', "%{$dataForm['key']}%")->get();           
            return view("{$this->view}.permissoes", compact('model', 'dataForm', 'permissoes'));
        }
        
        
*/
   



}