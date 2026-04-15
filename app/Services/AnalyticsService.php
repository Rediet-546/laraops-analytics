<?php

namespace App\Services;

use App\Models\Analytics;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function track(string \, array \ = [])
    {
        Analytics::create([
            'metric' => \,
            'date' => now()->toDateString(),
            'metadata' => \,
            'value' => 1
        ]);

        Cache::forget('analytics_summary');
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
}
