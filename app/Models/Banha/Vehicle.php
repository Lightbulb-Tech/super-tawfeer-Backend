<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'image', 'price_of_km', 'status', 'is_active'];
}
