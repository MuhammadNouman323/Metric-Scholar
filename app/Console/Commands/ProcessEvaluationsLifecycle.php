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
        $scheduledToActivate = Evaluation::scheduled()->where('start_date', '<=', $today)->get();

        foreach ($scheduledToActivate as $evaluation) {
            $evaluation->update([
                'status' => 'active',
                'activated_at' => now(),
            ]);

            event(new EvaluationActivated($evaluation));

            $this->info("Activated evaluation ID: {$evaluation->id}");
        }

        if ($scheduledToActivate->isEmpty()) {
            $this->info('No scheduled evaluations to activate.');
        }
    }
}
