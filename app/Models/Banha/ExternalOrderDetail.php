<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['external_order_id', 'order_category_id', 'details', 'image', 'price'];

    public function externalOrder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExternalOrder::class, 'external_order_id');
    }

    public function orderCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderCategory::class, 'order_category_id');
    }

}
