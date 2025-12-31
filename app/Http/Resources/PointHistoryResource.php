<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PointHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'order_code' => (string)@$this->order->code,
            'points' => (double)$this->points,
            'price' => (double)$this->price,
            'status' => (string)$this->status,
            'date' => (string)$this->created_at->format('Y-m-d'),
        ];


    }
}
