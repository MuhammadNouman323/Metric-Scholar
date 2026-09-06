<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationRescheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation,
        public string $oldStartDate,
        public string $oldEndDate,
        public string $userRole
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $actionUrl = $this->userRole === 'faculty' ? url('/faculty/dashboard') : url('/student/feedback');

        return (new MailMessage)
            ->subject('Evaluation Rescheduled: '.$this->evaluation->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('The course evaluation **'.$this->evaluation->title.'** has been rescheduled.')
            ->line('**New Schedule:** '.$this->evaluation->start_date->format('M d, Y').' — '.$this->evaluation->end_date->format('M d, Y'))
            ->line('**Previous Schedule:** '.$this->oldStartDate.' — '.$this->oldEndDate)
            ->action($this->userRole === 'faculty' ? 'View Details' : 'Submit Feedback', $actionUrl)
            ->line('Please visit your dashboard and note the updated dates.');
    }

    public function toArray(object $notifiable): array
    {
        $dashboardUrl = $this->userRole === 'faculty' ? '/faculty/dashboard' : '/student/dashboard';

        return [
            'title' => 'Course Evaluation Rescheduled',
            'message' => 'The evaluation "'.$this->evaluation->title.'" has been rescheduled to '.$this->evaluation->start_date->format('M d, Y').' — '.$this->evaluation->end_date->format('M d, Y').' (previously '.$this->oldStartDate.' — '.$this->oldEndDate.'). Please check your dashboard for updated details.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
            'semester' => $this->evaluation->semester,
            'new_start_date' => $this->evaluation->start_date->format('Y-m-d'),
            'new_end_date' => $this->evaluation->end_date->format('Y-m-d'),
            'old_start_date' => $this->oldStartDate,
            'old_end_date' => $this->oldEndDate,
            'action_url' => $dashboardUrl,
        ];
    }
}