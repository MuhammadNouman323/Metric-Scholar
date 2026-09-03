<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $token,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = URL::route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return (new MailMessage)
            ->subject('Reset Your Scholar Metric Password')
            ->view('emails.auth.password-reset', [
                'firstName' => explode(' ', $notifiable->name)[0],
                'email' => $notifiable->email,
                'resetUrl' => $resetUrl,
            ]);
    }
}
