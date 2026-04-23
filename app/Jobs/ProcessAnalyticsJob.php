<?php

namespace App\Jobs;

use App\Models\Analytics;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessAnalyticsJob implements ShouldQueue
{
    use Queueable;

    protected $metric;
    protected $metadata;

    public function __construct(string $metric, array $metadata = [])
    {
        $this->metric = $metric;
        $this->metadata = $metadata;
    }

    public function handle(): void
    {
        Analytics::create([
            'metric' => $this->metric,
            'date' => now()->toDateString(),
            'metadata' => $this->metadata,
            'value' => 1
        ]);

        Log::info('Analytics processed', [
            'metric' => $this->metric,
            'time' => now()
        ]);
    }
}