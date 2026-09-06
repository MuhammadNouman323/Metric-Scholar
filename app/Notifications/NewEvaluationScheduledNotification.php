<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEvaluationScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation,
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
            ->subject('New Evaluation Scheduled: '.$this->evaluation->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('A new Course evaluation has been scheduled for your '.($this->userRole === 'faculty' ? 'course' : 'course(s)').'.')
            ->line('**Evaluation:** '.$this->evaluation->title)
            ->line('**Type:** '.$this->evaluation->evaluation_type)
            ->line('**Semester:** '.$this->evaluation->semester)
            ->line('**Open:** '.$this->evaluation->start_date->format('M d, Y').' — '.$this->evaluation->end_date->format('M d, Y'))
            ->action($this->userRole === 'faculty' ? 'Analyze' : 'Submit Feedback', $actionUrl)
            ->line($this->userRole === 'faculty' ? 'Please view your course feedback details on your profile.' : 'Please complete your feedback before the deadline passes.');
    }

    public function toArray(object $notifiable): array
    {
        $dashboardUrl = $this->userRole === 'faculty' ? '/faculty/dashboard' : '/student/dashboard';

        return [
            'title' => 'New Course Evaluation Scheduled',
            'message' => 'A new course evaluation has been scheduled. The evaluation will be available from '.$this->evaluation->start_date->format('M d, Y').' to '.$this->evaluation->end_date->format('M d, Y').'. Please check your dashboard for details.',
            'evaluation_id' => $this->evaluation->id,
            'evaluation_title' => $this->evaluation->title,
            'semester' => $this->evaluation->semester,
            'start_date' => $this->evaluation->start_date->format('Y-m-d'),
            'end_date' => $this->evaluation->end_date->format('Y-m-d'),
            'action_url' => $dashboardUrl,
        ];
    }
}
