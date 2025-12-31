<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray($request)
    {
        return   [
            'id' => (integer)$this->id,
            'question' => (string)$this->question,
            'answer' => (string)@$this->answer,
        ];


    }
}
