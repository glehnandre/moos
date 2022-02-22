<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;
    public $nome;


    public function __construct($token, $nome)
    {
        $this->token = $token;
        $this->nome = $nome;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nova senha para a sua conta MooS')
            ->line($this->nome . ',')
            ->line('Você está recebendo esse email porque solicitou uma nova senha ou porque seu primeiro cartão foi criado com sua conta MooS.')
            ->action('Nova Senha', url('password/reset', $this->token))
            ->line('Se você não solicitou uma nova senha, desconsidere este e-mail.');
    }
}
