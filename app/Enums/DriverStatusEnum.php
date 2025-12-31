<?php

namespace App\Enums;

enum DriverStatusEnum: string
{
    case Available = 'available';
    case NotAvailable = 'not_available';

    public function lang()
    {
        return match ($this) {
            self::Available => __('banha.available'),
            self::NotAvailable => __('banha.not_available'),
        };
    }
}
