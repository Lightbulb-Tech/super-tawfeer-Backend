<?php

namespace App\Enums;

enum RegisterTypeEnum: string
{
    case Normal = "normal";
    case Google = "google";
    case Apple = "apple";
    case Facebook = "facebook";

//    public function lang()
//    {
//        return match ($this) {
//            self::Normal => __('Normal'),
//            self::Google => __('Google'),
//            self::Apple => __('Apple'),
//            self::Facebook => __('Facebook'),
//        };
//    }
}
