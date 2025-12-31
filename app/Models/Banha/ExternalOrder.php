<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalOrder extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'user_id', 'area_id', 'address', 'driver_id', 'lat', 'lon', 'name', 'phone', 'shipping_price', 'orders_price', 'final_price', 'status'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function driver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function orderDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExternalOrderDetail::class, 'external_order_id');
    }


}
