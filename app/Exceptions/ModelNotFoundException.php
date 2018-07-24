<?php

namespace App\Exceptions;;

use Exception;

class ModelNotFoundException extends Exception
{
    
    
    /**
     * All of the guards that were checked.
     *
     * @var array
     */
    protected $guards;




    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'Item não encontrado.', array $guards = [])
    {
        parent::__construct($message);

        $this->guards = $guards;
    }






    /**
     * Get the guards that were checked.
     *
     * @return array
     */
    public function guards()
    {
        return $this->guards;
    }


}
