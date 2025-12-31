<?php

namespace App\Enums;

enum PointsTransferRequestStatusEnum: string
{
    case Pending = 'pending';
    case Refused = 'refused';
    case Accepted = 'accepted';

    public function lang()
    {
        return match ($this) {
            self::Pending => __('banha.pending'),
            self::Refused => __('banha.refused'),
            self::Accepted => __('banha.accepted'),
        };
    }
}
