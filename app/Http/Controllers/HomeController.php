<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log; 
use Auth;
 
class HomeController extends Controller
{
 
    

    /**
    * Função para buscar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function log(Request $request ){
        try {                  
            Log::channel('slack')->info('Visualizando '  , [  'usuario' => Auth::user()->name ] );
            return response()->json( 'ok' , 200);
        }         
        catch(Exception $e) {           
            return response()->json( 'Erro interno'  , 500);    
        }
    }




 


 
 

  
}
