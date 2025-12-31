<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettingTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['address', 'app_name'];
}
