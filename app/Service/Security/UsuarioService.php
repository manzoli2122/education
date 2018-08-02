<?php

namespace App\Service\Security ;
 
use App\User;
use App\Models\Security\Perfil;
use App\Models\Security\LogUsuarioPerfil;
use App\Service\VueService;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Logging\LogService;
use App\Jobs\CrudProcessJob; 
use Log;


class UsuarioService extends VueService  implements UsuarioServiceInterface 
{

    protected $model; 
    protected $perfil; 
    protected $logSeguranca;
    protected $dataTable;
    protected $route = "user";
    protected $logservice ;

    /**
    * Save  
    *
    * @param mixed $inputPermissions
    *
    * @return void
    */
    public function __construct( User $user , Perfil $perfil , LogUsuarioPerfil $log , DataTables $dataTable , LogService $servicelog ){        
        $this->dataTable = $dataTable ;   
        $this->model = $user ;   
        $this->perfil = $perfil ;
        $this->logSeguranca = $log ;  
        $this->logservice = $servicelog  ;   
    }




    /**
    * Funcao para buscar os usuario pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
            ->addColumn('action', function($linha) {
                return'<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a> '
                 .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' ;
            })
            ->make(true); 
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
    public function  BuscarPerfilDataTable( $request , $userId ){ 
        $usuario = $this->model->find($userId); 
        $models = $usuario->perfis( ); 
        return $this->dataTable->eloquent($models)
            ->addColumn('action', function($linha) {
                return  
                '<button data-id="'.$linha->perfil_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
            ;
            })
            ->make(true);  
    }






    /**
    * Função para buscar os logs de perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilDataTableLog( $request , $userId ){ 
        $models = $this->logSeguranca->getDatatable($userId);  
        return $this->dataTable
                ->eloquent($models)
                 ->editColumn('created_at', function ($log) {
                    return $log->created_at->format('d/m/Y H:i');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') like ?", ["%$keyword%"]);
                })
                ->make(true); 
    }









    /**
    * Função para Adicionar um Perfil a um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPerfilAoUsuario( int $perfilId , int  $userId , Request  $request )
    {        
        $usuario = $this->model->find($userId);
        $perfil = $this->perfil->find( $perfilId );
        if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
             abort(403, 'Você não tem permissão para adicionar o perfil Admin.');
        }
        $usuario->attachPerfil($perfil);

        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' =>  $request->header('host'),
            'usuario' => Auth::user(),
        ] ;

        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                'Perfil_Usuario' ,   
                'adicionarPerfilAoUsuario' ,  
                ['dado1' => $usuario->log() , 'dado2' => $perfil->log() ] , 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u') 
            )
        );   
       // Log::info('dispachou');
        $this->Log( $perfilId , $userId  , Auth::user()->id , 'Adicionar' ,$request->server('REMOTE_ADDR') , $request->header('host') );  
    }
 







    
    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPerfilDoUsuario( int $perfilId , int  $userId , Request  $request)
    {        
        $usuario = $this->model->find($userId);
        $perfil = $this->perfil->find($perfilId); 
        if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
             abort(403, 'Você não tem permissão para remover o perfil Admin.');
        } 
        if( $perfil->nome == 'Admin' and  Auth::user()->id === $userId ){
            abort(403, 'Não é possível remover o seu perfil Admin.'); 
        } 
        $usuario->detachPerfil($perfilId); 
 
        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user(),
        ] ;

        dispatch( 
            new CrudProcessJob(  
                $this->logservice , 
                'Perfil_Usuario' ,   
                'excluirPerfilDoUsuario' ,  
                ['dado1' => $usuario->log() , 'dado2' => $perfil->log() ] , 
                $info ,  
                now()->format('Y-m-d\TH:i:s.u') 
            )
        );   
 
        $this->Log( $perfilId , $userId  , Auth::user()->id , 'Excluir'  ,$request->server('REMOTE_ADDR') , $request->header('host') ); 
    }









    /**
    * Função para  salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    * 
    * @param string  $acao
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    private function  Log( int $perfilId , int $userId  , int $autorId , string $acao , string $ip_v4 , string $host )
    {         
        $log =  new LogUsuarioPerfil();
        $log->user_id = $userId;
        $log->autor_id = $autorId;
        $log->perfil_id = $perfilId;
        $log->acao = $acao ;
        $log->ip_v4 = $ip_v4;
        $log->host = $host; 
        $log->save(); 
    }







      /**
    * Função para buscar os Perfis que um usuario não possui; 
    *  
    * @param int  $userId 
    *
    * @return List $pefis
    */
    public function BuscarPerfisParaAdicionar(   int $userId  ){ 
        return  $this->perfil->perfisParaAdicionarAoUsuario( $userId ,  Auth::user()->hasPerfil('Admin') );
    }
 
    







     /**
    * Função para buscar log de perfis do usuario
    *
    * @param Request $request
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function elasticsearch( Request $request , $userId  ){

        $query = [
            'query' => [   
                'bool'=>[
                    'must' => [ 
                        'match' => [ 'dados.dado1.usuario.id' => $userId ]
                    ],
                    'should' => [
                        'match' => [ "acao" => "adicionarPerfilAoUsuario"],
                        'match' => [ "acao" => "excluirPerfilDoUsuario"]
                    ]
                ]
            ],
            'size' => 15
        ] ;
            
            
            
        $postString = json_encode(  $query ); 
        
        



        $ch = curl_init();
        $options = array(
            CURLOPT_URL => env('LOG_SLACK_URL_SEARCH'), 
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => $postString
        );
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        } 
        curl_setopt_array($ch, $options); 

        $result = curl_exec($ch) ;
        if ( $result === false) {
            $curlErrno = curl_errno($ch); 
            $curlError = curl_error($ch); 
            Log::error( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) );
            curl_close($ch); 
        }  else{ 
            $resultJson = json_decode( $result );  
            if( isset($resultJson->error)  ){
                Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
        }


        //Log::info($result); 
        //Log::info($resultJson);

        return  $resultJson->hits->hits  ;
    }







  
}
