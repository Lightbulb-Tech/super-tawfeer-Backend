<?php

namespace App\Enums;

enum WalletStatusEnum: string
{
    case Pending = 'pending';
    case Failed = 'failed';
    case Success = 'success';

    public function lang()
    {
        return match ($this) {
            self::Pending => __('banha.pending'),
            self::Failed => __('banha.failed'),
            self::Success => __('banha.success'),
        };
    }
}
