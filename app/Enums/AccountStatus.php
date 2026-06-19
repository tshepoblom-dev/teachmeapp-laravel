<?php namespace App\Enums;
enum AccountStatus: string {
    case Active     = 'active';
    case Suspended  = 'suspended';
    case Banned     = 'banned';
    case PendingKyc = 'pending_kyc';
}
