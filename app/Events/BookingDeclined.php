<?php

namespace App\Events;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingDeclined
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Booking $booking,
        public readonly User    $declinedBy,
        public readonly ?float  $penaltyApplied = null,
    ) {}
}