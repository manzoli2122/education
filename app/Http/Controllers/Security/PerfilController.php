<?php

 
namespace  App\Http\Controllers\Security;



use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Config; 
use DataTables;
use App\Http\Controllers\VueController;

use App\Models\Perfil;
use App\Models\Permissao;
use App\Service\Security\PerfilServiceInterface;

use App\User;
use Auth; 
 


class PerfilController extends VueController
{
    
    protected $service; 
    protected $model;    
    protected $permissao;
    
    protected $user; 
    protected $name = "Perfil";    
    protected $view = "perfil";    
    protected $route = "perfil";
       
        
    
    
    public function __construct( PerfilServiceInterface $service , Perfil $perfil, Permissao $permissao , User $user ){
        
        $this->service = $service ;  
 
        $this->model = $perfil ;
        
        $this->permissao = $permissao ;
        
        $this->user = $user;


        //$this->middleware('permissao:perfis');  
      
       
    }


 

  
        /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    
    public function getDatatable(Request $request)
    {
        $models = $this->model->getDatatable();
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                        . '<a href="'.route("{$this->route}.permissao", $linha->id).'" class="btn btn-warning btn-xs" title="Permissões"> <i class="fa fa-unlock"></i> Permissões </a> '      
                       // . '<a href="'.route("{$this->route}.usuarios", $linha->id).'" class="btn btn-success btn-xs" title="Usuários"> <i class="fa fa-users"></i> Usuários </a> '      
                        . '<a href="'.route("{$this->route}.edit", $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '   ;
            })->make(true);
    }
        
*/



        public function usuarios($id)
        {            
            $model = $this->model->find($id);
            $users = $model->usuarios()->get();
            return view("{$this->view}.usuarios", compact('model','users'));
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











        //=======================================================================================================================================================
        //                                          PERMISSÕES
        //=======================================================================================================================================================

        
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
            
            

           // $model = $this->model->find($id);           
          //  return view("{$this->view}.permissoes", compact('model'));
        }


        

        public function permissoes_ori($id)
        {            
            $model = $this->model->find($id);           
            return view("{$this->view}.permissoes", compact('model'));
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
        
        

   



}