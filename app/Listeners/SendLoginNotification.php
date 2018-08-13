<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLoginNotification implements ShouldQueue
{


  
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }





    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        //
    }



}
