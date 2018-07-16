<?php

 
namespace  App\Http\Controllers\Security;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Config; 
use DataTables;
use App\Http\Controllers\VueController;

use App\Models\Perfil;
use App\User;
use App\Service\Security\UsuarioServiceInterface;
 
use Illuminate\Console\Command; 
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
        
        //$this->middleware('permissao:permissoes');
       
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

*/
    
    public function perfis($id)
    {        
        $model = $this->user->find($id);
        return view("{$this->view}.perfis", compact('model'));
    }
    



    public function perfisParaAdd($id)
    {    
        $model = $this->user->find($id);
        $perfis = $this->perfil->perfils_sem_usuario($id, Auth::user()->hasPerfil('Admin'));
        return view("{$this->view}.perfis-add", compact('model','perfis'));  
    }
    




    public function addPerfil(Request $request , $id)
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
    



    public function deletePerfil($id,$perfilId)
    {        
        $model = $this->user->find($id);
        $perfil = $this->perfil->find($perfilId);
        if( $perfil->nome == 'Admin' and ! Auth::user()->hasPerfil('Admin'))
            return redirect()->route("{$this->route}.perfis" ,$id)->with(['error' => 'Perfil não pode ser Removido']);
        $model->detachPerfil($perfilId);   
        return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfil Removido com sucesso']);
    }

 
 


}