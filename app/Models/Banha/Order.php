<?php

namespace App\Models\Banha;

use App\Models\OrderCancellation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'driver_id', 'status', 'payment_type', 'code', 'invoice_pdf', 'total_points', 'coupon_id', 'coupon_type', 'coupon_value', 'coupon_discount', 'products_price', 'app_commission', 'shipping_price', 'area_id', 'lat', 'lon', 'final_price', 'notes'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function pointHistory()
    {
        return $this->hasOne(PointHistory::class, 'order_id');
    }

    public function cancelReason()
    {
        return $this->hasOne(OrderCancellation::class, 'order_id');
    }
}
