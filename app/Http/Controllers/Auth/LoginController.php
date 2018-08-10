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
    	$this->middleware('guest')->except('logout' );
        // $this->middleware('guest')->except('logout' ,'authenticate' );
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
            $this->enviarFalharFilaElasticSearxh( $request, 'Falha de Autenticação - token vazio!!' );            
            abort(401 , "Falha de Autenticação - token vazio!!" );
    	}

    	try{
    		$payload = Auth::guard('api')->payload(); 

    		if(!$user = User::withoutGlobalScope('ativo')->find($payload['id'])){
    			$user = $this->cadastro( $request, $payload);
            }
            else{
                $this->atualizarCadastro( $request, $payload , $user );
            }

    		//FIX-ME TESTAR VIA TOKEN DO SCA
    		//Auth::guard('web')->loginUsingId( $user->id );
    		Auth::guard('web')->loginUsingId( Auth::guard('api')->user()->id );

    		$this->authenticated( $request, Auth::guard('web')->user() );

    		return  redirect()->intended('/');

    	}
    	catch(TokenInvalidException $e){
            $this->enviarFalharFilaElasticSearxh( $request, 'Falha de Autenticação - token Invalido!!' );
            abort(401 , "Falha de Autenticação - Token Invalido!!" );
    	}
    	catch(TokenExpiredException $e){
            $this->enviarFalharFilaElasticSearxh( $request, 'Falha de Autenticação - token expirado!!' );
            abort(401 , "Falha de Autenticação - Token expirado!!" );
    	}
    	catch(JWTException $e){
            $this->enviarFalharFilaElasticSearxh( $request, 'Falha de Autenticação !!' ); 
    		abort(401 , "Falha de Autenticação - Token vazio!!" );
    	} 
    	catch(Exception $e){
            $this->enviarFalharFilaElasticSearxh( $request, 'Falha de Autenticação !!' ); 
    		abort(401 , "Falha de Autenticação!!" );
    	} 

    }





    
    /**
     *  Enviar falha para o elastic
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param   App\User $usuario 
     * 
     */
    protected function enviarFalharFilaElasticSearxh(Request $request,  $causa)
    { 
    	if(env('LOG_ELASTIC_LOG')){
            $this->EnviarFilaElasticSearchLog( 
                $request,  
                'App\User', 
                'FalhaLogin' ,
                ['causa' => $causa ]  );
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
                //Pega a IP do usuário 
                'ip'   => getenv("REMOTE_ADDR") ,
                 //Pega o nome da Máquina do usuário
                'host' => gethostbyaddr(getenv("REMOTE_ADDR")),
                'usuario' => $request->user()->log()['usuario'],

                // 'ip'   => $request->server('REMOTE_ADDR') ,
                // 'host' => $request->header('host'),
                // 'usuario' => $request->user()->log()['usuario'],
            ] ; 
        }
        else{
            $info =   [   
                //Pega a IP do usuário 
                'ip'   => getenv("REMOTE_ADDR") ,
                 //Pega o nome da Máquina do usuário
                'host' => gethostbyaddr(getenv("REMOTE_ADDR")), 
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

                'setor_qdi_id' => $payload['setor_qdi'] ,    
                'setor_qdi_dsc'=> $payload['setor_dsc'] ,    
                'setor_qdi_lft' => $payload['setor_lft'] ,   
                'setor_qdi_rgt' => $payload['setor_rgt'] , 

                'created_ip' =>   $request->server('REMOTE_ADDR'),  
                'created_host' =>   $request->header('host'),  
                'updated_ip' =>  $request->server('REMOTE_ADDR') ,  
                'updated_host' =>  $request->header('host') ,   
            ]
        ); 

        // envia dados do cadastro para o elasticsearch
    	if(env('LOG_ELASTIC_LOG')){
    		$info =   [   
                //Pega a IP do usuário 
                'ip'   => getenv("REMOTE_ADDR") ,
                 //Pega o nome da Máquina do usuário
                'host' => gethostbyaddr(getenv("REMOTE_ADDR")),
    			// 'ip'   => $request->server('REMOTE_ADDR') ,
    			// 'host' => $request->header('host'),
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
     * FIX-ME ADICIONAR ENVIO DE EMAIL DE CADASTRO
     *  Função para realizar o cadastro de um usuario no sistema
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  Array  $payload
     *
     * @return Response
    */
    public function atualizarCadastro( Request $request, $payload , User $usuario )
    {
        //cria o usuario
        
        $usuario->email = $payload['email'];
        $usuario->quadro_dsc = $payload['quadro_dsc'] ;
        $usuario->post_grad_dsc = $payload['post_grad_dsc'] ;
        $usuario->ome_qdi_id =  $payload['ome_qdi_id'] ; 
        $usuario->ome_qdi_dsc =  $payload['ome_qdi_dsc'] ; 
        $usuario->ome_qdi_lft = $payload['ome_qdi_lft'] ; 
        $usuario->ome_qdi_rgt = $payload['ome_qdi_rgt'] ; 
        $usuario->setor_qdi_id = $payload['setor_qdi'] ;    
        $usuario->setor_qdi_dsc = $payload['setor_dsc'] ;    
        $usuario->setor_qdi_lft = $payload['setor_lft'] ;   
        $usuario->setor_qdi_rgt = $payload['setor_rgt'] ; 
        $usuario->updated_ip =  $request->server('REMOTE_ADDR') ; 
        $usuario->updated_host =  $request->header('host') ;  
        $usuario->save();


        // envia dados do cadastro para o elasticsearch
    	if(env('LOG_ELASTIC_LOG')){
    		$info =   [   
                //Pega a IP do usuário 
                'ip'   => getenv("REMOTE_ADDR") ,
                 //Pega o nome da Máquina do usuário
                'host' => gethostbyaddr(getenv("REMOTE_ADDR")),
    			// 'ip'   => $request->server('REMOTE_ADDR') ,
    			// 'host' => $request->header('host'),
    			'usuario' => $usuario->log()['usuario'],
    		] ; 
    		dispatch( 
    			new FIlaElasticSearchLog('App\User', 'Atualizacao', $user->logCompleto(), $info, now()->format('Y-m-d\TH:i:s.u') )
    		);  
    	}


    }







}
