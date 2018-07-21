<?php
 
namespace  App\Http\Controllers\Security;

use Illuminate\Http\Request;  
use App\Http\Controllers\VueController;

use App\Models\Perfil;
use App\User;

use App\Service\Security\UsuarioServiceInterface;
  
use Auth;   



class UsuarioController extends VueController
{
    
    protected $service; 
    protected $model;    
    protected $perfil;
     
    protected $name  = "Usuario";    
    protected $view  = " usuario";    
    protected $route = "usuario";
    
    
    public function __construct( UsuarioServiceInterface $service , Perfil $perfil, User $user ){
        
        $this->service = $service ;  
 
        $this->perfil = $perfil ;
        
        $this->model = $user ;
        
        $this->middleware('auth');

        //$this->middleware('permissao:permissoes');
       
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
           $this->service->adicionarPerfilAoUsuario($request->get('perfil') , $userId , Auth::user()->id ,
                                 $request->server('REMOTE_ADDR'),$request->header('host')  );   
        }   
        return response()->json($this->perfil->perfils_sem_usuario($userId ,Auth::user()->hasPerfil('Admin')),200);
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
        $this->service->excluirPerfilDoUsuario($perfilId , $userId , Auth::user()->id , $request->server('REMOTE_ADDR'),$request->header('host')  );  
        return response()->json( $this->perfil->perfils_sem_usuario( $userId , Auth::user()->hasPerfil('Admin'))  , 200); 
    }





















    public function BuscarPerfilDataTable( Request $request , $id )
    {     
        try {            
            return  $this->service->BuscarPerfilDataTable( $request , $id);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }








    
    public function perfisDatatableLog( Request $request , $id )
    {     
        try {            
            return  $this->service->BuscarPerfilDataTableLog( $request , $id);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }









    
 /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    
    public function getDatatable()
    {
        $models = $this->user->getDatatable();
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return  '<a href="'.route("{$this->route}.perfis", $linha->id).'" class="btn btn-primary btn-xs" title="Perfis"> <i class="fa fa-user"></i> Perfis </a> '   ;
            })->make(true);
    }







    
    public function getDatatable( Request $request ){
        try {            
            return  $this->service->BuscarDataTable( $request);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        } 
    }



*/
    




    public function perfis_ori2($id)
    {      
        try {  
            if( !$model = $this->service->BuscarPeloId( $id ) ){       
                return response()->json('Item não encontrado.', 404 );    
            }                   
            return response()->json( $model->perfis , 200);
        }         
        catch(Exception $e) {           
            return response()->json( 'Erro interno', 500);    
        } 
 
    }

    
    

    public function perfis_ori($id)
    {      
        $model = $this->user->find($id);
        return view("{$this->view}.perfis", compact('model'));
    }

 





    

    public function perfisParaAdd($id)
    {    
        try {  
            if( !$model = $this->service->BuscarPeloId( $id ) ){       
                return response()->json('Item não encontrado.', 404 );    
            }                   
            return response()->json( $this->perfil->perfils_sem_usuario($id, Auth::user()->hasPerfil('Admin')) , 200);
        }         
        catch(Exception $e) {           
            return response()->json( 'Erro interno', 500);    
        }  
         
    }
    




    
    
    




    public function perfisParaAdd_ori($id)
    {    
        $model = $this->user->find($id);
        $perfis = $this->perfil->perfils_sem_usuario($id, Auth::user()->hasPerfil('Admin'));
        return view("{$this->view}.perfis-add", compact('model','perfis'));  
    }
    






    
    public function addPerfil(Request $request , $id)
    {        
        $model = $this->model->find($id);
        
        
        
        
        
        if( $request->get('perfil') != '' ){
            
            $perfil = $this->perfil->find($request->get('perfil'));
            
            if( $perfil->nome != 'Admin' or Auth::user()->hasPerfil('Admin'))
                $model->attachPerfil($request->get('perfil'));
            
            
             
        }

        return response()->json('Feito' , 200);

        //return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfis vinculados com sucesso']);
    }
    





    public function addPerfil_ori(Request $request , $id)
    {        
        $model = $this->user->find($id);
        if($request->get('perfis') != ''){
            foreach ($request->get('perfis') as  $value) {
                $perfil = $this->perfil->find($value);
                if( $perfil->nome != 'Admin' or Auth::user()->hasPerfil('Admin'))
                    $model->attachPerfil($value);
            }
        }
        return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfis vinculados com sucesso']);
    }
    





/*





    public function deletePerfil($id,$perfilId)
    {        
        $model = $this->model->find($id);
        $perfil = $this->perfil->find($perfilId);
        if( $perfil->nome == 'Admin' and ! Auth::user()->hasPerfil('Admin'))
            return response()->json( 'Voce não tem permissão para isso' , 500);
            //return redirect()->route("{$this->route}.perfis" ,$id)->with(['error' => 'Perfil não pode ser Removido']);
        $model->detachPerfil($perfilId); 
        
        return response()->json('Feito' , 200);
        //return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfil Removido com sucesso']);
    }

 
 

 */


}