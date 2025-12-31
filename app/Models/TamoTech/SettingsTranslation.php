<?php

namespace App\Models\TamoTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['text_sidebar', 'text_login', 'subText_login','footer_text'];
}
