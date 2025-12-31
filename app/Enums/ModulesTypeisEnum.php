<?php

namespace App\Enums;

enum ModulesTypeisEnum: string
{
    case Product = 'product';
    case Category = 'category';

    public function lang()
    {
        return match ($this) {
            self::Product => __('banha.product'),
            self::Category => __('banha.category'),
        };
    }
}
