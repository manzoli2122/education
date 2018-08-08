<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Security\Perfil; 


class PerfilRemovidoNotification extends Notification implements ShouldQueue
{



    use Queueable;




    public $perfil  ;





    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
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
            return ['database' , 'mail'];
        }
        return ['database'];
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
                    ->subject(' Perfil removido')
                    ->markdown('emails.perfil.remover' , ['perfil' =>$this->perfil->nome  ] );
                    
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
            'perfil' => $this->perfil 
        ];
    }





}
