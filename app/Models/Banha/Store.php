<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'logo', 'cover_image'];

    public function features()
    {
        return $this->hasMany(StoreFeature::class, 'store_id');
    }
}
