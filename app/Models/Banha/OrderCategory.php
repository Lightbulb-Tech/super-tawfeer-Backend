<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_active'];

}
