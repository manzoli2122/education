<?php 

namespace App\Seguranca;
 

use Illuminate\Support\Facades\Facade;

class AALFacade extends Facade
{
    
    protected static function getFacadeAccessor()
    {
        return 'aal';
    }
 
}
