<?php namespace App\Enums;
enum PaymentFlow: string {
    case Redirect = 'redirect';
    case Modal    = 'modal';
    case Direct   = 'direct';
    case Wallet   = 'wallet';
}
