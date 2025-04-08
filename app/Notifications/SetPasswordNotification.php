<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Establece tu contraseña')
            ->line('Por favor haz clic en el botón para establecer tu contraseña.')
            ->action('Establecer Contraseña', url('/establecer-contrasena?token='.$this->token))
            ->line('Si no solicitaste este registro, puedes ignorar este mensaje.');
    }
}