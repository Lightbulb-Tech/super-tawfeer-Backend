<?php

namespace App\Enums;

enum ExternalOrderStatusEnum: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case InProgress = 'in_progress';
    case OnTheWay = 'on_the_way';
    case Delivered = 'delivered';
    case Returned = 'returned';
    case CanceledFromUser = 'canceled_from_user';
    case CanceledFromAdmin = 'canceled_from_admin';

    public function lang()
    {
        return match ($this) {
            self::Pending => __('banha.pending'),
            self::Confirmed => __('banha.confirmed'),
            self::InProgress => __('banha.in_progress'),
            self::OnTheWay => __('banha.on_the_way'),
            self::Delivered => __('banha.delivered'),
            self::Returned => __('banha.returned'),
            self::CanceledFromUser => __('banha.canceled_from_user'),
            self::CanceledFromAdmin => __('banha.canceled_from_admin'),
        };
    }
}
