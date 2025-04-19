<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordSetupNotification extends Notification
{
    use Queueable;

    protected $token;

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
        $url = route('password.setup', ['token' => $this->token]);

        return (new MailMessage)
                    ->subject('Configura tu contraseña y verifica tu correo')
                    ->greeting('¡Hola!')
                    ->line('Gracias por registrarte. Por favor, haz clic en el botón de abajo para configurar tu contraseña y verificar tu correo electrónico.')
                    ->action('Configurar Contraseña', $url)
                    ->line('Si no solicitaste este registro, ignora este correo.')
                    ->salutation('Saludos, Equipo de la Aplicación');
    }
}