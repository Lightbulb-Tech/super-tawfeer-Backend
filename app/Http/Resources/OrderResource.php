<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'code ' => (string)@$this->code,
            'status' => (string)$this->status,
            'payment_type' => (string)$this->payment_type,
//            'user' => UserResource::make($this->user),
            'user_id' =>(integer) $this->user_id,
            'coupon' => isset($this->coupon_id) ? CouponResource::make($this->coupon) : null,
            'coupon_discount' => (string)$this->coupon_discount ?? 0,
            'products_price' => (double)$this->products_price,
            'app_commission' => (double)$this->app_commission,
            'shipping_price' => (double)$this->shipping_price,
            'area' => AreaResource::make($this->area),
            'final_price' => (double)$this->final_price,
            'total_points' => (double)$this->total_points,
            'notes' => (string)$this->notes,
            'products' => OrderDetailsResource::collection($this->details),
        ];


    }
}
