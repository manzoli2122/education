<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request;  
use Auth; 
use Yajra\DataTables\DataTables; 
use App\Models\Mailable;


class ProfileController extends Controller
{


    protected $dataTable;

    protected $mailable;



    public function __construct(   DataTables $dataTable  , Mailable $mailable ){  
        $this->dataTable = $dataTable ;
        $this->mailable = $mailable ;
        $this->middleware('auth');  
    }
    


    /**
    * Função para buscar dados do usuario logado
    *
    * @param Request $request
    *   
    * @return view
    */
    public function profile(Request $request ){
        $user = Auth::user();
        return view('usuario.profile' , compact('user'));
    }






    /**
    * Função para buscar as notificações por email datatable
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function getNotificacaoDatatable(Request $request ){

        $models = $this->mailable->getDatatable(); 
        $usuario =  Auth::user();  
        return $this->dataTable->eloquent($models)
        ->addColumn('action', function($linha) use($usuario ) { 
            if($usuario->hasMailable($linha->nome)){
                return  '<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"> Desativar </button>' 
                ;
            }
            return  '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar">Ativar </button>' 
            ;
        })
        ->make(true);  
    }
    




    /**
     * FIX-ME FAZER LOG
    * Função para ativar 
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  AtivarNotificacaoEmail( Request $request , $mailable_id ){ 
        $usuario =  Auth::user();  
        $mailable = $this->mailable->find( $mailable_id );
        $usuario->attachMailable($mailable);  
        return response()->json( 'Ativado', 200 );
    }




    /**
    * Função para desativar  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  DesativarNotificacaoEmail( Request $request , $mailable_id ){
        $usuario =  Auth::user();  
        $mailable = $this->mailable->find( $mailable_id );
        $usuario->detachMailable($mailable);  
        return response()->json( 'Destivado' , 200 );
    }






    /**
    *  Função que busca as notificações no banco de dados
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  notifications( Request $request  ){
        $notifications = $request->user()->unreadNotifications ;
        return response()->json( $notifications , 200 );
    }



    /**
    *  Função para marcar como lida todas as notificações
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  limparNotifications( Request $request  ){ 
        $request->user()->unreadNotifications->markAsRead(); 
    }

    
}
