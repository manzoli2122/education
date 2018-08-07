<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PerfilAdicionado extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


     /**
     * The subject of the message.
     *
     * @var string
     */
    public $subject ;




    public $perfil ;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( string $perfil )
    {
        $this->perfil = $perfil;        
        $this->subject = "Perfil adicionado" ;
    }


    public $tries = 1 ;



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.perfil.adicionar')
         ->with('perfil' , $this->perfil );
    }
}
