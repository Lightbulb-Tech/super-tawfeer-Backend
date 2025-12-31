<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'area' => (string)@$this->area->title,
            'lat' => (double)$this->lat,
            'lon' => (double)$this->lon,
            'address' => (string)@$this->address,
            'shipping_price' => (double)@$this->area->shipping_price,
            'selected' => (boolean)@$this->selected,
        ];


    }
}
