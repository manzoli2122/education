<?php
 
namespace  App\Http\Controllers\Security;


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Security\PermissaoServiceInterface;
use App\Logging\LogService;


class PermissaoController extends VueController
{
    
    protected $service;  
    protected $view = "permissao";    
    protected $model_name = 'Permissão'   ; 
    protected $logservice   ;
    
    public function __construct( PermissaoServiceInterface $service    , LogService $servicelog  ){
        $this->logservice = $servicelog  ; 
        $this->service = $service ;    
        $this->middleware('auth');
        $this->middleware('permissao:permissoes');
        $this->middleware('perfil:Admin')->only('update', 'destroy');
       
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

 
}