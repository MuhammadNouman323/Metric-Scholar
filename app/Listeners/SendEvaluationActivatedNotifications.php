<?php

namespace App\Listeners;

use App\Events\EvaluationActivated;
use App\Models\User;
use App\Notifications\EvaluationAvailableNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEvaluationActivatedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(EvaluationActivated $event): void
    {
        // Get all students who have generated tokens for this evaluation
        $studentIds = $event->evaluation->tokens()->pluck('student_id')->unique();

        $students = User::whereIn('id', $studentIds)->get();

        if ($students->isNotEmpty()) {
            Notification::send($students, new EvaluationAvailableNotification($event->evaluation));
        }
    }
}
