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

use Log;


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
    	$this->middleware('guest')->except('logout' );
        //$this->middleware('guest')->except('logout' ,'authenticate');
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
    		abort(401 , "Falha de Autenticação - Token Invalido!!" );
    	}
    	catch(TokenExpiredException $e){
    		abort(401 , "Falha de Autenticação - Token expirado!!" );
    	}
    	catch(JWTException $e){
    		abort(401 , "Falha de Autenticação - Token vazio!!" );
    	} 
    	catch(Exception $e){
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
    	$info =   [   
    		'ip'   => $request->server('REMOTE_ADDR') ,
    		'host' => $request->header('host'),
    		'usuario' => Auth::user()->log()['usuario'],
    	] ; 
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







}
