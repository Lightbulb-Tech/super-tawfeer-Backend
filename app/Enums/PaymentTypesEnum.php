<?php

namespace App\Enums;

enum PaymentTypesEnum: string
{
    case Cash = 'cash';
    case Wallet = 'wallet';
    public function lang()
    {
        return match ($this) {
            self::Cash => __('banha.cash'),
            self::Wallet => __('banha.wallet'),
        };
    }
}
