<?php

namespace App\Console\Commands;

use App\Models\Analytics;
use Illuminate\Console\Command;

class SeedAnalyticsCommand extends Command
{
    protected $signature = 'analytics:seed {days=30}';
    protected $description = 'Seed fake analytics data for testing';

    public function handle()
    {
        $days = $this->argument('days');
        $this->info("Seeding {$days} days of analytics data...");

        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($i);
            
            Analytics::create([
                'metric' => 'page_view',
                'value' => rand(10, 500),
                'date' => $date->toDateString(),
                'metadata' => ['source' => 'cli_seed']
            ]);
        }

        $this->info('Analytics seeding completed!');
    }
}