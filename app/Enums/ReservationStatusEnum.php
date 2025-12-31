<?php

namespace App\Enums;

enum ReservationStatusEnum: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Loading = 'loading';
    case Completed = 'completed';
    case CanceledFromUser = 'canceled_from_user';
    case CanceledFromAdmin = 'canceled_from_admin';

    public function lang()
    {
        return match ($this) {
            self::Pending => __('banha.pending'),
            self::Confirmed => __('banha.confirmed'),
            self::Loading => __('banha.Loading'),
            self::Completed => __('banha.completed'),
            self::CanceledFromUser => __('banha.canceled_from_user'),
            self::CanceledFromAdmin => __('banha.canceled_from_admin'),
        };
    }
}
