<?php

namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportResolved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  string  $outcome  'warned' | 'suspended' | 'dismissed'
     */
    public function __construct(
        public readonly Report $report,
        public readonly string $outcome,
    ) {}
}
