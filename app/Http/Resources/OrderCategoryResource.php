<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => (integer)$this->id,
            'title' => (string)$this->title,
        ];
        return $data;
    }
}
