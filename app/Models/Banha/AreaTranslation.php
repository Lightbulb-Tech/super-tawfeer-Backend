<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['title'];
}
