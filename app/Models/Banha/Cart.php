<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'offer_id', 'offer_type', 'offer_value', 'offer_discount', 'final_price', 'price', 'quantity', 'points'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
