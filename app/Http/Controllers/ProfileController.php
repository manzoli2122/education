<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log; 
use Auth;
 
class ProfileController extends Controller
{
 
    

    public function __construct(   ){  
        $this->middleware('auth');  
    }
    


    /**
    * Função para buscar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function profile(Request $request ){
        $user = Auth::user();
        return view('usuario.profile' , compact('user'));
    }



    
 


 
 

  
}
