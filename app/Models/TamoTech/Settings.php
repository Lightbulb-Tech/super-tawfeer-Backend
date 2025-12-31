<?php

namespace App\Models\TamoTech;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['text_sidebar', 'text_login', 'subText_login','footer_text'];
    protected $fillable = ['image_login','icon'];
}
