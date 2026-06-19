<?php

namespace App\Events;

use App\Models\KycApplication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KycRejected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly KycApplication $application,
    ) {}
}