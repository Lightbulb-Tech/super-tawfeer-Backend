<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExternalOrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'order_category_id' => (integer)$this->order_category_id,
            'order_category' => OrderCategoryResource::make($this->orderCategory),
            'details' => (string)$this->details,
            'image' => show_file($this->image),
            'price' => (double)@$this->price,
        ];
    }
}
