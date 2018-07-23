<?php
 
namespace  App\Http\Controllers\Security;


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Security\PermissaoServiceInterface;



class PermissaoController extends VueController
{
    
    protected $service;  
    protected $view = "permissao";    
    
    
    public function __construct( PermissaoServiceInterface $service   ){
        
        $this->service = $service ;    
        $this->middleware('auth');
        $this->middleware('permissao:permissoes');
       // $this->middleware('perfil:Admin')->only('update', 'destroy');
       
    }

 


     /**
    * Função para buscar as Perfis de uma Permissao pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */
    public function BuscarPerfisDataTable( Request $request , $permissaoId )
    {     
        try {            
            return  $this->service->BuscarPerfisDataTable( $request , $permissaoId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }




 /*
 
    

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


  */



 

}