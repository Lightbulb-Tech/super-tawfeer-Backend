<?php

namespace App\Enums;

enum CouponTypeisEnum: string
{
    case Fixed = 'fixed';
    case Percentage = 'percentage';

    public function lang()
    {
        return match ($this) {
            self::Fixed => __('banha.fixed'),
            self::Percentage => __('banha.percentage'),
        };
    }
}
