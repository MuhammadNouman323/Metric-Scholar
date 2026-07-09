<?php

namespace App\Console\Commands;

use App\Events\EvaluationActivated;
use App\Events\EvaluationClosed;
use App\Models\Evaluation;
use Illuminate\Console\Command;

class ProcessEvaluationsLifecycle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evaluation:process-lifecycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the evaluation lifecycle (activate scheduled, close active)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = today();

        // 1. Close Expired Active Evaluations
        $activeToClose = Evaluation::active()->where('end_date', '<', $today)->get();
        foreach ($activeToClose as $evaluation) {
            $evaluation->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);

            event(new EvaluationClosed($evaluation));

            $this->info("Closed evaluation ID: {$evaluation->id}");
        }

        // 2. Activate Scheduled Evaluations
        // Ensure no evaluation is currently active
        if (! Evaluation::active()->exists()) {
            $scheduledToActivate = Evaluation::scheduled()->where('start_date', '<=', $today)->get();

            // We should only activate ONE evaluation if there happen to be multiple scheduled for today
            $evaluationToActivate = $scheduledToActivate->first();

            if ($evaluationToActivate) {
                $evaluationToActivate->update([
                    'status' => 'active',
                    'activated_at' => now(),
                ]);

                event(new EvaluationActivated($evaluationToActivate));

                $this->info("Activated evaluation ID: {$evaluationToActivate->id}");

                // If there are others, we skip them for now to enforce the single active rule
                if ($scheduledToActivate->count() > 1) {
                    $this->warn('More than one scheduled evaluation was eligible. Only one was activated to maintain the single-active rule.');
                }
            } else {
                $this->info('No scheduled evaluations to activate.');
            }
        } else {
            $this->info('An evaluation is already active. Skipping activation of scheduled evaluations.');
        }
    }
}
