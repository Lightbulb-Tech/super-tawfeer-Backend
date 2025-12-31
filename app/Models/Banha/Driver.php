<?php

namespace App\Models\Banha;

use App\Enums\ExternalOrderStatusEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'image', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function completedOrder(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class, 'driver_id')->where('status', OrderStatusEnum::Delivered->value);

    }
    public function completedExternalOrder(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExternalOrder::class, 'driver_id')->where('status', ExternalOrderStatusEnum::Delivered->value);

    }
}
