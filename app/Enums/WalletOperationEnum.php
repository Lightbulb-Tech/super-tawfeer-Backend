<?php

namespace App\Enums;

enum WalletOperationEnum: string
{
    case TransferPoints = 'transfer_points';
    case PayOrder = 'pay_order';

    public function lang()
    {
        return match ($this) {
            self::TransferPoints => __('banha.transfer_points'),
            self::PayOrder => __('banha.pay_order'),
        };
    }
}
