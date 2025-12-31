<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'price', 'product_point', 'quantity', 'offer_id', 'offer_type', 'offer_value', 'offer_discount', 'final_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
