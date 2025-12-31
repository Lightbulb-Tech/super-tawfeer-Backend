<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'image' => show_file(@$this->image),
            'type' => (string)$this->type,
            'module_name' => (string)$this->module_name,
            'module_id' => (integer)@$this->module_id,
        ];


    }
}
