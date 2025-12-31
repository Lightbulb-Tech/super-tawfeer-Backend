<?php

namespace App\Enums;

enum SliderTypeisEnum: string
{
    case Fixed = 'fixed';
    case Module = 'module';

    public function lang()
    {
        return match ($this) {
            self::Fixed => __('banha.fixed'),
            self::Module => __('banha.module'),
        };
    }
}
