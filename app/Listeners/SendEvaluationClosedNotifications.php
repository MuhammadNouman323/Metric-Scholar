<?php

namespace App\Listeners;

use App\Events\EvaluationClosed;
use App\Models\User;
use App\Notifications\EvaluationClosedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEvaluationClosedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(EvaluationClosed $event): void
    {
        // Notify students who participated
        $studentIds = $event->evaluation->tokens()->where('is_used', true)->pluck('student_id')->unique();

        $students = User::whereIn('id', $studentIds)->get();

        if ($students->isNotEmpty()) {
            Notification::send($students, new EvaluationClosedNotification($event->evaluation));
        }
    }
}
