<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Log;
use App\User;
use App\Models\Mailable;
use App\Mail\LoginMail;
use App\Mail\LoginSuccessMail; 
use Illuminate\Support\Facades\Mail;
use App\Jobs\CrudProcessJob;


use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;



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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        abort(401 , "Falha de Autenticação!!" );
       // return redirect()
        return view('errors.401');
    }





    public function username(){
        return 'id';
    } 




    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout' ,'authenticate');
    }





    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
 
        $credentials = $request->only('token');

        if(! $credentials){
            abort(401 , "Falha de Autenticação - token vazio!!" );
        }

        try{
            $payload = Auth::guard('api')->payload();
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
          
        if(!User::withoutGlobalScope('ativo')
                    ->find($payload['id'])){
             $this->cadastro( $request, $payload);
        }
 
        Auth::guard('web')->loginUsingId( Auth::guard('api')->user()->id );
         
        $this->authenticated( $request, Auth::guard('web')->user() );

        return  redirect()->intended('/');
 
    }





    protected function authenticated(Request $request, $usuario)
    {
        if($usuario->hasMailable('Login') and  $usuario->email!== ''  ){
            Mail::to($usuario->email)->send(new LoginSuccessMail( $usuario ));
        }
        if(env('LOG_ELASTIC_LOG')){
            $this->EnviarFilaLog( $request,  'App\User', 'Login' , $usuario->log()  );
        } 
    }





    protected function  EnviarFilaLog( Request $request , $model, $acao ,  $dados   ){  
        $info =   [   
            'ip'   => $request->server('REMOTE_ADDR') ,
            'host' => $request->header('host'),
            'usuario' => Auth::user()->log()['usuario'],
        ] ; 
        dispatch( 
            new CrudProcessJob($model, $acao , $dados, $info , now()->format('Y-m-d\TH:i:s.u') )
        );   
    }




    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function cadastro( Request $request, $payload)
    {
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

        foreach(Mailable::get() as $mailable){
            $user->attachMailable( $mailable);
        }
    }







}
