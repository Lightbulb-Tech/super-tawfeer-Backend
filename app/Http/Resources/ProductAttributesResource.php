<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'attribute_name' => (string)$this->attribute_name,
            'attribute_value' => (string)@$this->attribute_value,
        ];


    }
}
