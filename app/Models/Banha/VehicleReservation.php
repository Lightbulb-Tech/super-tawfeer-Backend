<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleReservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','code', 'vehicle_id', 'name', 'phone', 'from_address', 'to_address', 'first_lat', 'first_lon', 'second_lat', 'second_lon', 'date', 'time',
        'details', 'price', 'number_of_km', 'price_of_km', 'coupon_id', 'coupon_type', 'coupon_value', 'coupon_discount', 'final_price', 'status'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

}
