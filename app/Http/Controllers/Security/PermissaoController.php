<?php

 
namespace  App\Http\Controllers\Security;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Config; 
use DataTables;
use App\Http\Controllers\VueController;

use App\Models\Perfil;
use App\Models\Permissao;
use App\Service\Security\PermissaoServiceInterface;

class PermissaoController extends VueController
{
    
    protected $service; 
    protected $model;    
    protected $perfil;
    protected $name = "Permissao";    
    protected $view = "permissao";    
    protected $route = "permissao";
    
    
    public function __construct( PermissaoServiceInterface $service , Perfil $perfil, Permissao $permissao ){
        
        $this->service = $service ;  
 
        $this->perfil = $perfil ;
        
        $this->model = $permissao ;
        
        $this->middleware('auth');
        //$this->middleware('permissao:permissoes');
       
    }



      /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    
    public function getDatatable( Request $request )
    {
        $models = $this->model->getDatatable();
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                        //. '<a href="'.route("{$this->route}.perfis", $linha->id).'" class="btn btn-success btn-xs" title="Perfis"> <i class="fa fa-user"></i> Perfis </a> '      
                        . '<a href="'.route("{$this->route}.edit", $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '   ;
            })->make(true);
    }
*/



    public function perfis($id)
    {        
        $model = $this->model->find($id);
        return view("{$this->view}.perfis", compact('model'));
    }
 




    public function perfisParaAdd($id)
    {            
        $model = $this->model->find($id);
        $perfis = $this->perfil->perfils_sem_permissao($id);
        return view("{$this->view}.perfis-add", compact('model','perfis'));
    }
    
    



    public function deletePerfil($id,$perfilId)
    {        
        $model = $this->model->find($id);        
        $model->detachPerfil($perfilId); 
        return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfil Removido com sucesso']);
    }




    public function addPerfil(Request $request , $id)
    {        
        $model = $this->model->find($id);        
        $model->attachPerfil($request->get('perfis'));            
        return redirect()->route("{$this->route}.perfis" ,$id)->with(['success' => 'Perfis vinculados com sucesso']);
    }




    public function pesquisarPerfis(Request $request , $id)
    {
        $dataForm = $request->except('_token');
        $model = $this->model->find($id);
        $perfis = $model->perfis()->where('nome','LIKE', "%{$dataForm['key']}%")
                                   ->get();       
        return view("{$this->view}.perfis", compact('model', 'dataForm', 'perfis'));
    }



}