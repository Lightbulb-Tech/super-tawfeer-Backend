<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => (integer)$this->id,
            'title' => (string)$this->title,
            'country' => (string)@$this->country->title,
            'shipping_price' => (double)@$this->shipping_price,
        ];
        if (isset($this->governorate)) {
            $data['governorate'] = @$this->governorate->title;
        }
        return $data;
    }
}
