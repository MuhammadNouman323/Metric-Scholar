<?php

namespace App\Jobs;

use App\Models\Feedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class ProcessAnonymousFeedback implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $feedbackData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->feedbackData['anonymous_token'] = Str::uuid()->toString();
        Feedback::create($this->feedbackData);
    }
}
