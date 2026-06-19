<?php namespace App\Enums;
enum BookingStatus: string {
    case Pending    = 'pending';
    case Accepted   = 'accepted';
    case Declined   = 'declined';
    case Cancelled  = 'cancelled';
    case InProgress = 'in_progress';
    case Completed  = 'completed';
    case Disputed   = 'disputed';
    case Refunded   = 'refunded';
}
