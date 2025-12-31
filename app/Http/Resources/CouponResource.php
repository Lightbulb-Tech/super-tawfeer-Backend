<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'code ' => (string)@$this->code,
            'usage_times' => (integer)$this->usage_times,
            'already_used' => (integer)$this->already_used,
            'from_date' => (string)@$this->from_date,
            'to_date' => (string)@$this->to_date,
            'type' => (string)@$this->type,
            'value' => (integer)@$this->value,
            'is_active' => (boolean)@$this->is_active,
        ];


    }
}
