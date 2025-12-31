<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExternalOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'code' => (string)$this->code,
            'status' => (string)$this->status,
            'user_id' => (integer)$this->user_id ?? null,
            'user' => UserResource::make($this->user),
            'area_id' => (integer)$this->area_id,
            'area' => AreaResource::make($this->area),
            'name' => (string)$this->name,
            'phone' => (string)@$this->phone,
            'lat' => (double)@$this->lat,
            'lon' => (double)@$this->lon,
            'shipping_price' => (double)@$this->shipping_price,
            'final_price' => (double)@$this->final_price,
            'order_details' => ExternalOrderDetailsResource::collection($this->orderDetails),
        ];
    }
}
