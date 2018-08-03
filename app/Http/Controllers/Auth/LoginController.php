<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 

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



    public function username(){
        return 'id';
    } 




    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
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

        //Auth::login(Auth::guard('api')->user() );
        // return Auth::guard('api')->user()->id;
        Auth::guard('web')->loginUsingId( Auth::guard('api')->user()->id );
        return  redirect()->intended('/home');


       //  return response()->json( Auth::guard('api')->user() ) ;
       // //return $credentials['token'];
        
       //  if (Auth::attempt($credentials)) {
       //      // Authentication passed...
       //      return  redirect()->intended('/home');
       //  }

    }




}
