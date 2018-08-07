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
        $this->middleware('auth:api', ['except' => ['login']]);
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

        return response()->json([
            'access_token' => env('APP_URL') .'login/token?token=' .$token ,  
            //'token_type' => 'bearer',
           // 'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);

 
    }



    protected function guard(){
        return Auth::guard('api');
    }

    
}
