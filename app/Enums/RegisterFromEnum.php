<?php

namespace App\Enums;

enum RegisterFromEnum: string
{
    case Android = "android";
    case Ios = "ios";
    public function lang()
    {
        return match ($this) {
            self::Android => __('Android'),
            self::Ios => __('Ios'),
        };
    }

}
