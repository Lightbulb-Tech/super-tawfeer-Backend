<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['address', 'app_name'];
    protected $fillable = ['email', 'phone', 'logo', 'app_commission', 'days', 'point_price'];
    protected $casts = [
        'days' => 'array'
    ];
}
