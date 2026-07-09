<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEvaluationScheduledNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation,
        public string $userRole
    ) {}

    public function via(object $notifiable): array
    {
        return ['database']; // Can add 'mail' if configured
    }

    public function toMail(object $notifiable): MailMessage
    {
        $dashboardUrl = $this->userRole === 'faculty' ? url('/faculty/dashboard') : url('/student/dashboard');

        return (new MailMessage)
            ->subject('New Faculty Evaluation Scheduled')
            ->line('A new faculty evaluation has been scheduled.')
            ->line('The evaluation will be available from '.$this->evaluation->start_date->format('M d, Y').' to '.$this->evaluation->end_date->format('M d, Y').'.')
            ->line('Please check your dashboard for details.')
            ->action('View Evaluation', $dashboardUrl);
    }

    public function toArray(object $notifiable): array
    {
        $dashboardUrl = $this->userRole === 'faculty' ? '/faculty/dashboard' : '/student/dashboard';

        return [
            'title' => 'New Faculty Evaluation Scheduled',
            'message' => 'A new faculty evaluation has been scheduled. The evaluation will be available from '.$this->evaluation->start_date->format('M d, Y').' to '.$this->evaluation->end_date->format('M d, Y').'. Please check your dashboard for details.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
            'semester' => $this->evaluation->semester,
            'start_date' => $this->evaluation->start_date->format('Y-m-d'),
            'end_date' => $this->evaluation->end_date->format('Y-m-d'),
            'action_url' => $dashboardUrl,
        ];
    }
}
