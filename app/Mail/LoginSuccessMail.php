<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;


class LoginSuccessMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected $user;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


     public $tries = 1 ;


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuario =  $this->user;
        return $this->markdown('emails.login.success' )
        ->with('usuario' , $this->user );
    }
}
