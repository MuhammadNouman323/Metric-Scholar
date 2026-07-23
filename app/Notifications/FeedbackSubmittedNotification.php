<?php

namespace App\Notifications;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation,
        public User $faculty,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Feedback Received')
            ->line('You have received new feedback for an evaluation.')
            ->line('Evaluation: '.$this->evaluation->title)
            ->line('Semester: '.$this->evaluation->semester)
            ->action('View Feedback', url('/faculty/dashboard'))
            ->line('Thank you for your dedication to teaching excellence.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Feedback Received',
            'message' => 'You have received new feedback for the evaluation: '.$this->evaluation->title.'.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
            'action_url' => '/faculty/dashboard',
        ];
    }
}
