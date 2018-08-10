<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;  
use App\User;
use App\Models\Mailable; 
use App\Mail\LoginSuccessMail; 
use Illuminate\Support\Facades\Mail;
use App\Jobs\FIlaElasticSearchLog;


use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
 


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;



    



    /**
     * url de redirecionamento do usuario após o login.
     *
     * @var string
    */
    protected $redirectTo = '/';






    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	//$this->middleware('guest')->except('logout' );
        $this->middleware('guest')->except('logout' ,'authenticate' , 'carregaBanco');
    }




    /**
     * Função para retornar quando neccesitar de fazer login
     * vai para pagina de erro de autenticação onde contém
     * informações de como logar no sistema.
     * 
     *
     * @return \Exception 401
    */
    public function showLoginForm()
    {
    	abort(401 , "Falha de Autenticação!!" );  
    }
    // Invalida a função login tradicional
    public function login(Request $request)
    {
    	abort(401 , "Falha de Autenticação!!" );  
    }





    /**
     *  Retorna o nome do campo usuado para localizar um usuário
     * 
     *
     * @return string 
    */
    public function username(){
    	return 'id';
    } 






    /**
     * Função para autenticar um usuario via token
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {

    	$credentials = $request->only('token');

    	if(!$credentials){
            if(env('LOG_ELASTIC_LOG')){
                $this->EnviarFilaElasticSearchLog( $request,  'App\User', 'FalhaLogin' , ['causa' => 'Falha de Autenticação - token vazio!!']  );
            } 
            abort(401 , "Falha de Autenticação - token vazio!!" );
    	}

    	try{
    		$payload = Auth::guard('api')->payload(); 

    		if(!$user = User::withoutGlobalScope('ativo')->find($payload['id'])){
    			$user = $this->cadastro( $request, $payload);
    		}

    		//FIX-ME TESTAR VIA TOKEN DO SCA
    		//Auth::guard('web')->loginUsingId( $user->id );
    		Auth::guard('web')->loginUsingId( Auth::guard('api')->user()->id );

    		$this->authenticated( $request, Auth::guard('web')->user() );

    		return  redirect()->intended('/');

    	}
    	catch(TokenInvalidException $e){
            if(env('LOG_ELASTIC_LOG')){
                $this->EnviarFilaElasticSearchLog( $request,  'App\User', 'FalhaLogin' , ['causa' => 'Falha de Autenticação - token Invalido!!']  );
            } 
    		abort(401 , "Falha de Autenticação - Token Invalido!!" );
    	}
    	catch(TokenExpiredException $e){
            if(env('LOG_ELASTIC_LOG')){
                $this->EnviarFilaElasticSearchLog( $request,  'App\User', 'FalhaLogin' , ['causa' => 'Falha de Autenticação - token expirado!!']  );
            } 
    		abort(401 , "Falha de Autenticação - Token expirado!!" );
    	}
    	catch(JWTException $e){
            if(env('LOG_ELASTIC_LOG')){
                $this->EnviarFilaElasticSearchLog( $request,  'App\User', 'FalhaLogin' , ['causa' => 'Falha de Autenticação !!']  );
            } 
    		abort(401 , "Falha de Autenticação - Token vazio!!" );
    	} 
    	catch(Exception $e){
            if(env('LOG_ELASTIC_LOG')){
                $this->EnviarFilaElasticSearchLog( $request,  'App\User', 'FalhaLogin' , ['causa' => 'Falha de Autenticação !!']  );
            } 
    		abort(401 , "Falha de Autenticação!!" );
    	} 

    }







    /**
     * Função chamada logo após o usuário ser autenticado
     * notifica o usuário do acesso realizado.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param   App\User $usuario 
     * 
     */
    protected function authenticated(Request $request, User $usuario)
    {
    	if($usuario->hasMailable('Login') and  $usuario->email!== ''  ){
    		Mail::to($usuario->email)->send(new LoginSuccessMail( $usuario ));
    	}
    	if(env('LOG_ELASTIC_LOG')){
    		$this->EnviarFilaElasticSearchLog( $request,  'App\User', 'Login' , $usuario->log()  );
    	} 
    }






    /**
    * Função chamada para gravar log no elasticsearch   
    *
    * @param  \Illuminate\Http\Request $request
    *
    * @param   App\User $usuario 
    * 
    */
    protected function  EnviarFilaElasticSearchLog( Request $request , $model, $acao ,  $dados   ){  
    	
        if($request->user()){
            $info =   [   
                'ip'   => $request->server('REMOTE_ADDR') ,
                'host' => $request->header('host'),
                'usuario' => $request->user()->log()['usuario'],
            ] ; 
        }
        else{
            $info =   [   
                'ip'   => $request->server('REMOTE_ADDR') ,
                'host' => $request->header('host'), 
            ] ; 
        }
        
    	dispatch( 
    		new FIlaElasticSearchLog($model, $acao , $dados, $info , now()->format('Y-m-d\TH:i:s.u') )
    	);   
    }




    /**
     * FIX-ME ADICIONAR ENVIO DE EMAIL DE CADASTRO
     *  Função para realizar o cadastro de um usuario no sistema
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  Array  $payload
     *
     * @return Response
    */
    public function cadastro( Request $request, $payload)
    {
        //cria o usuario
    	$user = User::create(
    		[
    			'id' => $payload['id'] ,
    			'name' => $payload['name'],
    			'rg' => $payload['rg'],
    			'email' => $payload['email'],
    			'nf' =>$payload['nf'],                
    			'quadro_dsc' =>$payload['quadro_dsc'] ,
    			'post_grad_dsc' => $payload['post_grad_dsc'] ,
    			'status' => $payload['status'] , 
                'password' => $payload['password'] ,   // FIX-ME ALTERAR A QUESTÃO DA SENHA
                'ome_qdi_id' =>  $payload['ome_qdi_id'] , 
                'ome_qdi_dsc'=>  $payload['ome_qdi_dsc'] , 
                'ome_qdi_lft' => $payload['ome_qdi_lft'] , 
                'ome_qdi_rgt' => $payload['ome_qdi_rgt'] ,  
                'created_ip' =>   $request->server('REMOTE_ADDR'),  
                'created_host' =>   $request->header('host'),  
                'updated_ip' =>  $request->server('REMOTE_ADDR') ,  
                'updated_host' =>  $request->header('host') ,   
            ]
        ); 

        // envia dados do cadastro para o elasticsearch
    	if(env('LOG_ELASTIC_LOG')){
    		$info =   [   
    			'ip'   => $request->server('REMOTE_ADDR') ,
    			'host' => $request->header('host'),
    			'usuario' => $user->log()['usuario'],
    		] ; 
    		dispatch( 
    			new FIlaElasticSearchLog('App\User', 'Cadastro', $user->logCompleto(), $info, now()->format('Y-m-d\TH:i:s.u') )
    		);  
    	}

        // faz o usuario receber todos os tipos de notificação por email.
    	foreach(Mailable::get() as $mailable){
    		$user->attachMailable( $mailable);
    	}

    	return $user;

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
    public function carregaBanco(   ){
 
         

        $ch = curl_init();
        $options = array(
            // CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo/228/qdi', 
            CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo', 
            
            //CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            //CURLOPT_POSTFIELDS => $postString
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
            return  $result  ;
        }  else{ 
            $resultJson = json_decode( $result );  
            foreach($resultJson as $me ){
                if( $me->cpf!='' and $me->usuario_email !=''){
                    $me->id =  $me->cpf;
                    $this->cadastroTeste(   $me);
                }
                
            }
            




            if( isset($resultJson->error)  ){
                //Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
            return  $resultJson  ;
        }

        
    }





     /**
     * FIX-ME ADICIONAR ENVIO DE EMAIL DE CADASTRO
     *  Função para realizar o cadastro de um usuario no sistema
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  Array  $payload
     *
     * @return Response
    */
    public function cadastroTeste(  $payload)
    {
        //cria o usuario
    	$user = User::create(
    		[
    			'id' => $payload->id ,
    			'name' => $payload->nome,
    			'rg' => $payload->rg,
    			'email' => $payload->usuario_email,
    			'nf' =>$payload->num_funcional,                
    			'quadro_dsc' =>$payload->quadro_dsc ,
    			'post_grad_dsc' => $payload->post_grad_dsc ,
    			'status' => 'A', 
                'password' => bcrypt('123456') ,   // FIX-ME ALTERAR A QUESTÃO DA SENHA
                'ome_qdi_id' =>  $payload->ome_qdi , 
                'ome_qdi_dsc'=>  $payload->ome_dsc , 
                'ome_qdi_lft' => $payload->ome_lft , 
                'ome_qdi_rgt' => $payload->ome_rgt ,  
                  
            ]
        ); 

        // envia dados do cadastro para o elasticsearch
    	if(env('LOG_ELASTIC_LOG')){
    		$info =   [   
    			'ip'   => '0.0.0.0',
    			'host' => '0.0.0.0',
    			'usuario' => '00000000001',
    		] ; 
    		dispatch( 
    			new FIlaElasticSearchLog('App\User', 'Cadastro', $user->logCompleto(), $info, now()->format('Y-m-d\TH:i:s.u') )
    		);  
    	}


    	return $user;

    }








}
