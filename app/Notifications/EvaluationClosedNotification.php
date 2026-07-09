<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationClosedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Evaluation Closed: '.$this->evaluation->title)
            ->line('Thank you for participating in the faculty evaluation.')
            ->line('The evaluation period has ended and no further submissions will be accepted.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Evaluation Closed',
            'message' => 'Thank you for participating in the faculty evaluation. The evaluation period has ended.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
        ];
    }
}
