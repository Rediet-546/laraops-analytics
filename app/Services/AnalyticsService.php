<?php

namespace App\Services;

use App\Jobs\ProcessAnalyticsJob;
use App\Models\Analytics;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function track(string $metric, array $metadata = [])
    {
        // DISPATCH to queue instead of direct insert
        ProcessAnalyticsJob::dispatch($metric, $metadata);
    }

    public function getSummary()
    {
        return Cache::remember('analytics_summary', 60, function () {
            return [
                'total_views' => Analytics::where('metric', 'page_view')->sum('value'),
                'today_views' => Analytics::where('metric', 'page_view')
                                         ->where('date', now()->toDateString())
                                         ->sum('value'),
            ];
        });
    }

    public function clearCache(): void
    {
        Cache::forget('analytics_summary');
    }
}