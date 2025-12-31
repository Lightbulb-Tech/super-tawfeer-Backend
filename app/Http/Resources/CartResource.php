<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'product_image' => (string)show_file(@$this->product->image),
            'product_name' => (string)@$this->product->title,
            'product_price' => (double)$this->final_price,
            'product_quantity' => (integer)@$this->quantity,
            'product_points' => (double)@$this->product->points,
        ];
    }
}
