<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Security\Perfil;
use App\User;


class PerfilAdicionadoNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    //public $tries = 1 ; // Não funciona aqui, feito atrave do comando --tries=1

    public $perfil  ;

    public $user  ;



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
                    ->subject('Perfil Adicionado')
                    ->markdown('emails.perfil.adicionar' , ['perfil' =>$this->perfil->nome  ]);

                    // ->greeting('Perfil adicionado no ' . config('app.name')  ) 
                    // ->line('Agora você possui o perfil ' .$this->perfil->nome ) 
                    // ->line('Mensagem enviada automaticamente.' )

                    // ->line('Para desativar esta notificação entre no sistema e na parte de profile do usuário selecione gerenciar notificações.' )
                     
                    // ->salutation('Obrigado, ' .config('app.name') );
                    
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
