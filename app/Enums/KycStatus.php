<?php namespace App\Enums;
enum KycStatus: string {
    case NotSubmitted = 'not_submitted';
    case Pending      = 'pending';
    case UnderReview  = 'under_review';
    case Approved     = 'approved';
    case Rejected     = 'rejected';
    case Resubmitted  = 'resubmitted';
}
