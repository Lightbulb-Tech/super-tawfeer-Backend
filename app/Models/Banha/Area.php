<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['country_id', 'is_active', 'governorate_id', 'shipping_price'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Area::class, 'governorate_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'governorate_id');
    }
}
