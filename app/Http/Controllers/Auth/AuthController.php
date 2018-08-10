<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    

    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'carrega']]);
    }








    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        
        $credentials = request(['id', 'password']);
 
        $user = User::first();
        //$user = User::find('10000000000');
        if (! $token = $this->guard()->claims( 
            [ 
               'id' => '10000000000',
                'name' => 'Usuario.dtic',
                'email' => 'manzoli.elisandra@gmail.com',
                'rg' => 1001,
                'nf' => 1000001,                
                'quadro_dsc' =>'Admin',
                'post_grad_dsc' => "CEL",
                'status' => 'A', 
                'password' => bcrypt('123456'),
                'ome_qdi_id' => 1 , 
                'ome_qdi_dsc'=> 'PMES' , 
                'ome_qdi_lft' => 1, 
                'ome_qdi_rgt' => 10000,  

            ] )->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        return $this->respondWithToken($token);
 
    }





    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user()); 
    }





    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout(); 
        return response()->json(['message' => 'Successfully logged out']);
    }





    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh()); 
    }




    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        return '<a href="' . env('APP_URL') .'login/token?token=' .$token . '" target="_blank">link</a>' ;


        return response()->json([
            'access_token' => env('APP_URL') .'login/token?token=' .$token ,  
            //'token_type' => 'bearer',
           // 'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);

 
    }



    protected function guard(){
        return Auth::guard('api');
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
            if( isset($resultJson->error)  ){
                //Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
            return  $resultJson  ;
        }

        
    }

    
}
