<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'code' => (string)$this->code,
            'status' => (string)$this->status,
            'user_id' => (integer)$this->user_id ?? null,
            'user' => UserResource::make($this->user),
            'vehicle_id' => (integer)$this->vehicle_id,
            'vehicle' => VehicleResource::make($this->vehicle),
            'name' => (string)$this->name,
            'phone' => (string)@$this->phone,
            'from_address' => (string)@$this->from_address,
            'to_address' => (string)@$this->to_address,
            'first_lat' => (string)@$this->first_lat,
            'first_lon' => (string)@$this->first_lon,
            'second_lat' => (string)@$this->second_lat,
            'second_lon' => (string)@$this->second_lon,
            'date' => (string)@$this->date,
            'time' => (string)@$this->time,
            'details' => (string)@$this->details,
            'price' => (string)@$this->price,
            'number_of_km' => (string)@$this->number_of_km,
            'price_of_km' => (string)@$this->price_of_km,
            'coupon_id' => (string)@$this->coupon_id,
            'coupon_type' => (string)@$this->coupon_type,
            'coupon_value' => (string)@$this->coupon_value,
            'coupon_discount' => (string)@$this->coupon_discount,
            'final_price' => (string)@$this->final_price,
        ];
    }
}
