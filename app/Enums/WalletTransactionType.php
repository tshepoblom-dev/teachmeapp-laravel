<?php namespace App\Enums;
enum WalletTransactionType: string {
    case Deposit        = 'deposit';
    case Withdrawal     = 'withdrawal';
    case EscrowHold     = 'escrow_hold';
    case EscrowRelease  = 'escrow_release';
    case EscrowRefund   = 'escrow_refund';
    case PlatformFee    = 'platform_fee';
    case Payout         = 'payout';
    case Refund         = 'refund';
}
