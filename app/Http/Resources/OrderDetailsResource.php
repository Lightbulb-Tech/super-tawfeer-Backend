<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $productData = ProductResource::make($this->product)->toArray($request);

        $productData['quantity'] = (integer)$this->quantity;

        return $productData;


    }
}
