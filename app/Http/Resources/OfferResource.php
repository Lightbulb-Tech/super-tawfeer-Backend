<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'type' => (string)$this->type,
            'value' => (integer)$this->value,
            'from_date' => (string)$this->from_date,
            'to_date' => (string)@$this->to_date,
        ];


    }
}
