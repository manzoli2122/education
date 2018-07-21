<?php 

namespace App\Security;
 

use Illuminate\Support\Facades\Facade;

class AALFacade extends Facade
{
    
    protected static function getFacadeAccessor()
    {
        return 'aal';
    }
 
}
