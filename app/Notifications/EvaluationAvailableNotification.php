<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation
    ) {}

    public function via(object $notifiable): array
    {
        return ['database']; // Can add 'mail' if needed
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Faculty Evaluation Available')
            ->line('A new anonymous faculty evaluation has been opened.')
            ->line('Evaluation: '.$this->evaluation->title)
            ->line('Semester: '.$this->evaluation->semester)
            ->line('Start Date: '.$this->evaluation->start_date->format('M d, Y'))
            ->line('End Date: '.$this->evaluation->end_date->format('M d, Y'))
            ->action('Start Evaluation', url('/student/dashboard'))
            ->line('Please submit your feedback before the deadline.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Faculty Evaluation Available',
            'message' => 'A new anonymous faculty evaluation has been opened. Please submit your feedback before the deadline.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
            'action_url' => '/student/dashboard', // Adjust if route differs
        ];
    }
}
