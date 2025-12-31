<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => (integer)$this->id,
            'model' => (string)$this->model,
            'price_of_km' => (double)@$this->price_of_km,
            'image' => show_file($this->image),
        ];
        return $data;
    }
}
