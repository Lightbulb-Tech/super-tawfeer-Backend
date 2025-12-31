<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['image'];
}
