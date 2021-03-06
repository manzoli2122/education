<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Seguranca\Perfil; 
use Illuminate\Notifications\Messages\BroadcastMessage;

class PerfilAdicionadoNotification extends Notification implements ShouldQueue
{
 


    use Queueable;
     


    //public $tries = 1 ; // Não funciona aqui, feito atrave do comando --tries=1
 



    public $perfil  ;
    public $title  ;
    public $message  ;
 



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
        $this->title =  'Perfil ' . $perfil->nome .  ' Adicionado';
        $this->message =  'Parabéns!! agora você tem o perfil ' . $perfil->nome . '.';
        
    }

 





    /**
     * Get the notification's delivery channels.
     * verificar se o usuario quer receber este tipo de notificação por email
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->hasMailable('Perfil')){
            return ['database' , 'mail' , 'broadcast' ];
        }
        return ['database', 'broadcast'];
    }








    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        return (new MailMessage) 
                    ->subject('Perfil Adicionado')
                    ->markdown('emails.perfil.adicionar' , ['perfil' =>$this->perfil->nome  ]);
    }








    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return ( new BroadcastMessage([
                    'title' => $this->title  ,
                    'message' => $this->message ,
                ])
        )->onQueue('realtime');
    }





    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }







    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'perfil' => $this->perfil ,
            'title' => $this->title  ,
            'message' => $this->message ,
        ];
    }







}
